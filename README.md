# Magento 2 BuyNow 

This module add "BuyNow" button on product view page and list page to process directly checkout.

# Installation Instruction

* Copy the content of the repo to the <b>app/code</b> folder
* Run command:
<b>php bin/magento setup:upgrade</b>
* Run Command:
<b>php bin/magento setup:static-content:deploy</b>
* Now Flush Cache: <b>php bin/magento cache:flush</b>


<b>PRODUCT VIEW PAGE</b>

<img src="https://raw.githubusercontent.com/mageprince/all-module-screenshots/master/BuyNow/listpage.png" alt="View Page" border="0">

<b>PRODUCT LIST PAGE</b>

<img src="https://raw.githubusercontent.com/mageprince/all-module-screenshots/master/BuyNow/viewpage.png" alt="list page" border="0" />

<b>Store->Configuration->Mageprince->Buy Now->Settings</b>

<img src="https://raw.githubusercontent.com/mageprince/all-module-screenshots/master/BuyNow/settings.png" alt="config settongs" border="0" />

# How to find addtocart Id

Go to product view page and right click on addtocart button and click on inspect element. Then scroll up and find addtocart form id.


