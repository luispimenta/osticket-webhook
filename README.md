
osTicket-trello-integration
==============
An plugin for [osTicket](https://osticket.com) for integration with Trello. This is based on https://github.com/luispimenta/osticket-webhook.

Info
------
This plugin uses CURL and was designed/tested with osTicket-1.17

## Requirements
- php_curl

## Install
--------
1. [Download](https://github.com/luispimenta/osticket-webhook/releases/latest) the zip file, unzip inside a folder like name osticket-trello and place the contents into your `include/plugins`.
2. Now the plugin needs to be enabled & configured, select "Admin Panel" then "Manage -> Plugins" you should be seeing the list of currently installed plugins.
3. Click in Add New Plugin button. Select Trello Integration
4. Create a new Instance 
4. Click to edit the plugin and on `Trello Integration` fill all data needed
5. Click `Save Changes`! (If you get an error about curl, you will need to install the Curl module for PHP).
6. After that, go back to the list of plugins and tick the checkbox next to "Trello Integration" and select the "Enable" button.
7. That's it

## License

This plugin is released under the MIT license. See the file [LICENSE](LICENSE).
