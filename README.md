# Simurg Reltags Eklentisi
**Simurg Reltags**, MyBB forumlarında paylaşılan mesajlardaki dış bağlantılara otomatik olarak rel etiketleri eklemek için geliştirilmiş güçlü bir eklentidir. Bu eklenti, forumunuzun güvenliğini artırmak, SEO optimizasyonunu desteklemek ve bağlantı yönetimini özelleştirmek için tasarlanmıştır. Özellikle, oturum açmamış kullanıcılar (ziyaretçi grubu) için bağlantılara her zaman rel etiketleri eklenmesini sağlar, böylece forumunuzun kontrolünü elinizde tutabilirsiniz.

## Eklenti Özellikleri

- **Esnek Rel Etiketi Yönetimi:** Yönetim panelinden nofollow, noopener, noreferrer gibi rel etiketlerini kolayca ayarlayabilirsiniz.
* **Hariç Tutulan Alan Adları:** Belirttiğiniz alan adları (örneğin, mybb.pro) ve alt alan adları (örneğin, subdomain.mybb.pro) için rel etiketleri eklenmez. Aynı alan adının www'lu ve www'suz versiyonları otomatik olarak tekilleştirilir.
* **Grup İzinleri:** Belirli kullanıcı gruplarına (örneğin, yöneticiler veya moderatörler) rel etiketlerinin eklenmemesini sağlayabilirsiniz. Ancak, ziyaretçi grubu (oturum açmamış kullanıcılar) her zaman rel etiketleri ile işaretlenir.
* **Kolay Kurulum ve Yönetim:** Yönetim panelinden tüm ayarları hızlıca yapılandırabilirsiniz. Eklenti, MyBB 1.8.x sürümleriyle tam uyumludur.
* **Güvenlik ve Performans:** noopener gibi etiketlerle güvenliği artırırken, optimize edilmiş kod yapısıyla forum performansını korur.

### Neden Simurg Reltags Eklentisini Tercih Etmelisiniz?
**Simurg Reltags**, forumunuzdaki dış bağlantıları yönetmek için size tam kontrol sağlar. SEO stratejilerinizi destekler, kullanıcı gruplarına göre esnek ayarlar sunar ve özellikle ziyaretçi grubuna yönelik otomatik işaretleme ile spam veya istenmeyen bağlantıları en aza indirir.

## Eklenti Nasıl Kurulur?
Simurg Reltags eklentisini forumunuza kurmak için aşağıdaki adımları izleyin:

- **Eklentiyi İndirin:** Eklenti dosyalarını (**_simurg_reltags.php_** ve **_simurg_reltags.lang.php_**) indirin.
* **Dosyaları Yükleyin:** İndirdiğiniz **simurg_reltags.php** ve **simurg_reltags.lang.php** dosyalarını forumunuzun **_inc/plugins/_** dizinine yükleyin (FTP veya hosting paneli aracılığıyla).
* **Eklentiyi Etkinleştirin:** **MyBB Admin Kontrol Paneli’ne** gidin, **Eklentiler** bölümüne tıklayın ve **Simurg Reltags** eklentisini bulun. **“Etkinleştir”** butonuna tıklayın.
* **Ayarları Yapılandırın:** **MyBB Admin Kontrol Paneli’nden** **Yapılandırma > Ayarlar > Simurg Reltags Eklenti Ayarları** bölümüne gidin. Burada eklentiyi etkinleştirebilir, rel etiketlerini, muaf alan adlarını ve muaf grupları ayarlayabilirsiniz.
* **Test Edin:** Forumda birkaç test mesajı paylaşarak eklentinin doğru çalıştığından emin olun. Ziyaretçi grubu için rel etiketlerinin eklendiğini ve muaf gruplar/alan adları için eklenmediğini kontrol edin.
> [!NOTE]
> Eklentiyi kaldırmak isterseniz, **MyBB Admin Kontrol Paneli’nde**  **“Devre Dışı Bırak”** seçeneğini kullanabilir ve ardından simurg_reltags.php ve simurg_reltags.lang.php  dosyalarını FTP'nizden silebilirsiniz.

 ## Destek ve Yardım 
[Eklenti İçin  Destek](https://mybb.pro)
