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
1. [Download](https://github.com/luispimenta/osticket-webhook/releases/latest) the zip file, unzip and place the contents into your `include/plugins`.
2. Now the plugin needs to be enabled & configured, so login to osTicket, select "Admin Panel" then "Manage -> Plugins" you should be seeing the list of currently installed plugins.
3. Click on `Webhook Notifier` and paste https://api.osticket.com.br/push_notification ( for osticket admin app )
4. Click `Save Changes`! (If you get an error about curl, you will need to install the Curl module for PHP).
5. After that, go back to the list of plugins and tick the checkbox next to "Webhook Notifier" and select the "Enable" button.

## osticket admin app Setup:
- Download for [Android](https://play.google.com/store/apps/details?id=br.com.osticket.admin) or [ios](https://apps.apple.com/us/app/osticket-admin/id1605243534)
- Do login
- Accept push notification permission
- That's it

Note: only tickets with Assigned To Agents work

## License

This plugin is released under the MIT license. See the file [LICENSE](LICENSE).
