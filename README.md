[![Latest Stable Version](https://poser.pugx.org/mageprince/module-buynow/v)](//packagist.org/packages/mageprince/module-buynow)
[![Total Downloads](https://poser.pugx.org/mageprince/module-buynow/downloads)](//packagist.org/packages/mageprince/module-buynow)
[![Monthly Downloads](https://poser.pugx.org/mageprince/module-buynow/d/monthly)](//packagist.org/packages/mageprince/module-buynow)
[![License](https://poser.pugx.org/mageprince/module-buynow/license)](//packagist.org/packages/mageprince/module-buynow)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mageprince/magento2-buynow/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/mageprince/magento2-buynow/?branch=master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/mageprince/magento2-buynow/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)

# Magento 2 Buy Now 

The Buy Now extension for Magento 2 streamlines the purchase process by adding a “Buy Now” button on product pages. With a single click, customers can skip the cart and go straight to checkout, making quick purchases faster and more convenient.

Admin Configuration: `Admin > Stores > Configuration > MagePrince > Buy Now`

# 🚀 Installation Instructions

### 1. Install via composer

Run the following command in the Magento 2 root folder:

    composer require mageprince/module-buynow
    php bin/magento setup:upgrade
    php bin/magento setup:di:compile
    php bin/magento setup:static-content:deploy

### 2. Install manually (Not recommended)

Copy the content of the repo to the <b>app/code/Mageprince/BuyNow</b> folder and run the following command in the Magento 2 root folder:
  
    php bin/magento setup:upgrade
    php bin/magento setup:di:compile
    php bin/magento setup:static-content:deploy

# ⚠️ Notice

We do not provide support for placing the Buy Now button on related products, upsell blocks, wishlist, or any other custom locations, as this would require overriding Magento core .phtml files — something we strongly advise against in extension development. Many free and paid Buy Now modules override core files, which can lead to maintenance and upgrade issues.

# Add Buy Now in custom template

If you wish to add the button to custom product templates, use following code snippet:

    $buyNowBtnHtml = $this->getLayout()
        ->createBlock(\Mageprince\BuyNow\Block\Product\ListProduct::class)
        ->setProduct($_item)
        ->setButtonTitle('Buy Now')
        ->setTemplate('Mageprince_BuyNow::buynow.phtml')
        ->toHtml();
    echo $buyNowBtnHtml;

<b>Change `$_item` to current product object.</b>

You can use the code above to display the Buy Now button wherever you want on your product page. Just remember not to paste this code into the add to cart form or any other form. Put the code after `</form>` tag. Below is a screenshot showing how to use the code.

**Sample template:** _vendor/magento/module-catalog/view/frontend/templates/product/list/items.phtml_

<img src="https://github.com/mageprince/magento2-buynow/assets/24751863/5ad4baf6-5897-4ea4-adda-8244126524c3" width="500"/>


# 🤝 Contribution

Want to contribute to this extension? The quickest way is to <a href="https://help.github.com/articles/about-pull-requests/">open a pull request</a> on GitHub.

# 🛠 Support

If you encounter any problems or bugs, please <a href="https://github.com/mageprince/magento2-buynow/issues">open an issue</a> on GitHub.

# 📸 Screenshots

### Product view page

<img width="687" alt="Product List Page" src="https://github.com/mageprince/magento2-buynow/assets/24751863/02ca3bcf-76cf-4226-bc57-9618e765abb7">

### Product list page

<img width="687" alt="Product List Page" src="https://github.com/mageprince/magento2-buynow/assets/24751863/dfb6ac6c-dcde-4103-b0ab-497971763eef">

### Custom product template with buy now code

<img width="687" alt="Custom Product Template" src="https://github.com/mageprince/magento2-buynow/assets/24751863/cce268e2-e2ea-465b-82ca-afc3e0f8d209">



