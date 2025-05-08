<?php
/**
 * MyBB 1.8 Reltags Eklentisi v1.0 
 * Simurg Rel Tags, MyBB forumlarında paylaşılan gönderilerde ki dış bağlantılara otomatik olarak rel etiketleri eklemek için geliştirilmiş güçlü bir eklentidir.
 * 
 * @author Simurg
 * @version 1.0
 * @github @url -> https://github.com/SimurgTR/simurg-reltags
 * MyBB 1.8.38 ve PHP 8.2+ sürümlerinde test edilmiştir.
 * Son Güncelleme: 08.05.2025, 16:16
 */

// Eklentiye doğrudan erişimi engelle.
if (!defined("IN_MYBB")) {
    die("Bu dosyaya doğrudan erişemezsiniz.");
}

// MyBB Hook
$plugins->add_hook("postbit", "simurg_reltags_postbit");

// Eklenti bilgileri
function simurg_reltags_info() {

    // Dil dosyalarını yükle
    global $lang;
    if (!isset($lang->simurg_reltags)) {
        $lang->load("simurg_reltags");
    }
    return array(
        "name"          => $lang->simurg_reltags_ad ?? "Simurg Reltags",
        "description"   => $lang->simurg_reltags_desc ?? "Konu ve gönderilerde ki harici bağlantılara rel etiketleri eklemenizi sağlar.",
        "website"       => "https://github.com/SimurgTR/simurg-reltags",
        "author"        => "Simurg",
        "authorsite"    => "https://mybb.pro",
        "version"       => "1.0",
        "codename"		=> "simurg-reltags",
        "compatibility" => "18*"
    );
}

// Eklenti aktif edildiğinde
function simurg_reltags_activate() {
    global $db, $lang;
    if (!isset($lang->simurg_reltags)) {
        $lang->load("simurg_reltags");
    }
    // Ayar grubu
    $setting_group = array(
        "name" => "simurg_reltags",
        "title" => $lang->simurg_reltags_settings ?? "Simurg Reltags Eklenti Ayarları",
        "description" => $lang->simurg_reltags_settings_desc ?? "Simurg Reltags eklenti ayarlarını bu kısımdan yapılandırabilirsiniz.",
        "disporder" => 5,
        "isdefault" => 0
    );
    
    (int)$gid = $db->insert_query("settinggroups", $setting_group);
    
    // Ayarlar
    $settings[] = array(
        "name" => "simurg_reltags_enabled",
        "title" => $lang->simurg_reltags_aktif ?? "Eklenti Aktif Edilsin Mi?",
        "description" => $lang->simurg_reltags_aktif_desc ?? "Eklentinin aktif olup olmayacağını bu kısımdan ayarlayabilirsiniz.",
        "optionscode" => "yesno",
        "value" => "1",
        "disporder" => 1,
        "gid" => $gid
    );
    
    $settings[] = array(
        "name" => "simurg_reltags_attributes",
        "title" => $lang->simurg_reltags_reltag ?? "Rel Etiketleri",
        "description" => $lang->simurg_reltags_reltag_desc ?? "Dış linklere eklemek istediğiniz rel etiketlerini burada belirtebilirsiniz. Örneğin: nofollow, noopener gibi.",
        "optionscode" => "text",
        "value" => "nofollow noopener ugc noreferrer", // Varsayılan değerler.
        "disporder" => 2,
        "gid" => $gid
    );
    
    $settings[] = array(
        "name" => "simurg_reltags_exempt_domains",
        "title" => $lang->simurg_reltags_haric_alanadlari ?? "Hariç Tutulacak Alan Adları",
        "description" => $lang->simurg_reltags_haric_alanadlari_desc ?? "Rel etiketlerinin eklenmeyeceği, muaf tutulacak alan adlarını buraya giriniz.Alan adlarını her biri ayrı bir satır olacak şekilde ekleyebilir veya virgül (,) ile ayırarak da ekleyebilirsiniz. <strong>Alan adlarının başında HTTPS:// veya HTTP:// kullanmayın.</strong> Buraya eklediğiniz alan adlarının tüm varyasyonları muaf tutulacaktır. Örneğin: mybb.pro adresini eklediyseniz; www.mybb.pro, sub.mybb.pro dahil bütün uzantıları muaf tutulur.",
        "optionscode" => "textarea",
        "value" => "", // HTTP ve HTTPS olmadan eklenecek.
        "disporder" => 3,
        "gid" => $gid
    );
    
    $settings[] = array(
        "name" => "simurg_reltags_exempt_groups",
        "title" => $lang->simurg_reltags_haric_kgruplari ?? "Hariç Tutulacak Kullanıcı Grupları",
        "description" => $lang->simurg_reltags_haric_kgruplari_desc ?? "Rel Etiketlerinden muaf tutulacak kullanıcı gruplarının ID numaralarını virgül ile ayırarak buraya ekleyiniz. <strong>Not:</strong> <u>Ziyaretçi (ID: 1) gruplarında her zaman rel etiketleri eklenir.</u>",
        "optionscode" => "text",
        "value" => "", // Ziyaretçi Grubu (ID: 1) her zaman eklenir.
        "disporder" => 4,
        "gid" => $gid
    );
    
    foreach ($settings as $setting) {
        $setting['description'] = $db->escape_string($setting['description']);
        $db->insert_query("settings", $setting);
    }
    
    rebuild_settings();
}

// Alan adı normalizasyon fonksiyonu
function normalize_domain($domain) {
    $domain = strtolower(trim($domain));
    if (substr($domain, 0, 4) === 'www.') {
        return substr($domain, 4);
    }
    return $domain;
}
// Hariç tutulan alan adlarını kontrol eden fonksiyon
function simurg_reltags_is_exempt($url, $exempt_array) {
    $host = parse_url($url, PHP_URL_HOST);
    $host = $host ? strtolower($host) : '';
    if (empty($host)) {
        return true;
    }
    foreach ($exempt_array as $exempt) {
        $exempt = normalize_domain($exempt);
        if ($host === $exempt || substr($host, -strlen($exempt) - 1) === '.' . $exempt) {
            return true;
        }
    }
    return false;
}

// Ayarları ayrıştıran ve muaf alan adlarını işleyen fonksiyon
function simurg_reltags_parse() {
    global $mybb;
    
    $exempt_raw = trim($mybb->settings['simurg_reltags_exempt_domains']);
    $exempt_array = array_map('normalize_domain', array_filter(array_map('trim', preg_split('/[\r\n,;]+/', $exempt_raw))));
    $exempt_array = array_unique($exempt_array); // Tekrar edenleri kaldır
    
    return $exempt_array;
}
// Hariç tutulan kullanıcı gruplarını kontrol eden fonksiyon
function simurg_reltags_is_group_exempt($usergroup, $exempt_groups) {
    return in_array($usergroup, $exempt_groups);
}

// Linkleri işleyen ana fonksiyon
function simurg_reltags_handle_links($message, $usergroup) {
    global $mybb;
    
    if (empty($mybb->settings['simurg_reltags_enabled'])) {
        return $message;
    }
    
    $exempt_array = simurg_reltags_parse();
    $rel_attributes = trim($mybb->settings['simurg_reltags_attributes']);
    $exempt_groups = explode(',', $mybb->settings['simurg_reltags_exempt_groups']);
    
    // Ziyaretçi grubu (ID 1) için her zaman rel etiketi eklenir
    if ($usergroup == 1 || !simurg_reltags_is_group_exempt($usergroup, $exempt_groups)) {
        $pattern = '#<a\s+href=["\'](.*?)["\'].*?>#i';
        return preg_replace_callback($pattern, function($matches) use ($exempt_array, $rel_attributes) {
            $url = $matches[1];
            if (!simurg_reltags_is_exempt($url, $exempt_array)) {
                return str_replace('<a ', '<a rel="' . $rel_attributes . '" ', $matches[0]);
            }
            return $matches[0];
        }, $message);
    }
    
    return $message; // Muaf grupsa, rel etiketleri eklenmez
}
// postbit'te değişiklik yapan fonksiyon

function simurg_reltags_postbit(&$post) {
    $post['message'] = simurg_reltags_handle_links($post['message'], $post['usergroup']);
}

// Eklenti devre dışı bırakıldığında
function simurg_reltags_deactivate() {
    global $db;
    
    $db->delete_query("settinggroups", "name='simurg_reltags'");
    $db->delete_query("settings", "name LIKE 'simurg_reltags_%'");
    
    rebuild_settings();
}