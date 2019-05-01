# ArcherRebooter
### Script to reboot Archer C7 router from command line

Sometimes Wifi stops working on my home TP Link Archer C7 (while wired Ethernet and WAN parts work just fine). This can be fixed by simple rebooting the router.

This is not a big deal if I am at home. But what if I am not?

As I didn't want to expose admin interface to the Internet, the only solution was to kick reboot procedure from within internal network using some script.

For some reason TP Link does not provide any API that would allow to communicate with router, fortunatelly web interface is pretty straght forward so it was easy to mock its behaviour.

### Usage

Open `reboot.php` in any editor and set correct username, password and IP address of the router.

Then just run:

```csh
php reboot.php
```
