![osticket](https://demo.osticket.com.br/scp/images/ost-logo.png)

osTicket-webhook
==============
An plugin for [osTicket](https://osticket.com) to send webhooks, specially developed for the osticket admin app

Info
------
This plugin uses CURL and was designed/tested with osTicket-1.10.1

## Requirements
- php_curl

## Install
--------
1. [Download](https://github.com/luispimenta/osticket-webhook/releases/latest) the zip file, unzip inside a folder like name osticket-webhook and place the contents into your `include/plugins`.
2. Now the plugin needs to be enabled & configured, select "Admin Panel" then "Manage -> Plugins" you should be seeing the list of currently installed plugins.
3. Click in Add New Plugin button, you will se the plugin name Webhook notification and click in Install.
4. Click to edit the plugin and on `Webhook Notifier` paste https://api.osticket.com.br/push_notification ( for osticket admin app )
5. Click `Save Changes`! (If you get an error about curl, you will need to install the Curl module for PHP).
6. After that, go back to the list of plugins and tick the checkbox next to "Webhook Notifier" and select the "Enable" button.
7. That's it

## osticket admin app Setup:
- Download for [Android](https://play.google.com/store/apps/details?id=br.com.osticket.admin) or [ios](https://apps.apple.com/us/app/osticket-admin/id1605243534)
- Do login
- Accept push notification permission
- That's it

Note: only tickets with Assigned To Agents work

## License

This plugin is released under the MIT license. See the file [LICENSE](LICENSE).
