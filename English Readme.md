# Simurg Reltags Info
Simurg Rel Tags is a powerful plugin developed for MyBB forums to automatically add rel attributes to external links in posts. 
Designed to enhance forum security, support SEO optimization, and provide customizable link management, this plugin ensures that links from unauthenticated users (guest group) always receive rel attributes, giving you greater control over your forum.

## Features

- **Flexible Rel Attribute Management:** Easily configure rel attributes like nofollow, noopener, or noreferrer from the admin panel.
* **Exempt Domains:** Specify domains (e.g., mybb.pro) and their subdomains (e.g., subdomain.mybb.pro) to exclude from rel attributes. Duplicate entries (e.g., www.mybb.pro and mybb.pro) are automatically deduplicated.
* **Group Permissions:** Exempt specific user groups (e.g., administrators or moderators) from having rel attributes applied to their links. However, the guest group (unauthenticated users) always has rel attributes applied.
* **Easy Setup and Management:** Configure all settings quickly from the admin panel. The plugin is fully compatible with MyBB 1.8.x versions.
* **Security and Performance:**  Enhances security with attributes like noopener while maintaining forum performance with optimized code.
## Why Use Simurg Reltags?
**Simurg Reltags** gives you complete control over external links in your forum. It supports your SEO strategies, offers flexible group-based settings, and minimizes spam or unwanted links by consistently applying rel attributes to guest users’ links.

## Installation Instructions ##

To install the **Simurg Reltags** plugin on your forum, follow these steps:

- **Download the Plugin:** Obtain the plugin file (e.g., simurg_reltags.php, simurg_reltags.lang.php).
* **Upload the File:** Upload the **simurg_reltags.php**  and **simurg_reltags.lang.php** files to your forum’s **inc/plugins/** directory using FTP or your hosting panel.
* **Activate the Plugin:** Log in to your **MyBB Admin Control Panel**, navigate to the **Plugins** section, and locate **Simurg Reltags**. Click **“Activate”** to enable the plugin.
* **Configure Settings:** Go to **Configuration > Settings > Simurg Reltags Settings** in the **Admin Control Panel**. Here, you can enable the plugin, set rel attributes, specify exempt domains, and define exempt groups.
* **Test the Plugin:** Post a few test messages in your forum to verify that the plugin is working correctly. Ensure that rel attributes are added to guest group links and not added to exempt groups or domains.

**Note:** To uninstall the plugin, use the **“Deactivate”** option in the **Admin Control Panel** and then delete the **simurg_reltags.php** and **simurg_reltags.lang.php** files from the inc/plugins/ directory.

## Support
[Plugin Support](https://mybb.pro).
