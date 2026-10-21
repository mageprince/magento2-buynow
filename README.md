# Magento 2 Buy Now 

<p>
  <a href="https://packagist.org/packages/mageprince/module-buynow"><img src="https://img.shields.io/packagist/v/mageprince/module-buynow?style=for-the-badge&logo=packagist&logoColor=F28D1A&label=packagist&color=2F7FC1" alt="Latest Stable Version"></a>
  <a href="https://packagist.org/packages/mageprince/module-buynow/stats"><img src="https://img.shields.io/packagist/dt/mageprince/module-buynow?style=for-the-badge&logo=packagist&logoColor=white&label=downloads&color=D4B53A" alt="Total Downloads"></a>
  <a href="https://packagist.org/packages/mageprince/module-buynow/stats"><img src="https://img.shields.io/packagist/dm/mageprince/module-buynow?style=for-the-badge&label=monthly&color=D4B53A" alt="Monthly Downloads"></a>
  <a href="https://business.adobe.com/products/magento/magento-commerce.html"><img src="https://img.shields.io/badge/magento-2.4-6CB83A?style=for-the-badge" alt="Magento 2.4"></a>
  <a href="https://www.hyva.io/"><img src="https://img.shields.io/badge/hyv%C3%A4-compatible-0A1A3F?style=for-the-badge" alt="Hyvä compatible"></a>
  <a href="https://mage-os.org/"><img src="https://img.shields.io/badge/mage--os-compatible-F26322?style=for-the-badge" alt="Mage-OS compatible"></a>
  <a href="https://github.com/mageprince/magento2-buynow/blob/master/LICENSE"><img src="https://img.shields.io/badge/license-MIT-232F3E?style=for-the-badge" alt="License"></a>
  
</p>

The Buy Now extension for Magento 2 streamlines the purchase process by adding a “Buy Now” button on product pages. With a single click, customers can skip the cart and go straight to checkout, making quick purchases faster and more convenient.

<img src="https://github.com/hyva-themes.png?size=40" height="20" align="top" alt="Hyvä"/> **Hyvä Theme compatible** – works out of the box on Hyvä, no compat module needed.<br/>
<img src="https://github.com/mage-os.png?size=40" height="20" align="top" alt="Mage-OS"/> **Mage-OS compatible** – supports Mage-OS as well as Magento Open Source and Adobe Commerce.

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

# 🎨 Theme support

| Location | Luma | Hyvä |
|---|:---:|:---:|
| Product view page | ✅ | ✅ |
| Category product list | ✅ | ✅ |
| Search results and advanced search results | ✅ | ✅ |
| Custom templates (with the snippet below) | ✅ | ✅ |
| Related, upsell, cross-sell, wishlist | ❌ | ❌ |

- **Luma** uses the core add to cart forms and RequireJS. No template overrides.
- **Hyvä** works out of the box, with no compat module. The module adds `hyva_*` layout handles with Alpine/Tailwind-friendly templates and no RequireJS. The buttons use classes the Hyvä default theme already compiles (`btn btn-primary`), so no Tailwind rebuild is needed.

# ⚠️ Notice

We do not provide support for placing the Buy Now button on related products, upsell blocks, wishlist, or any other custom locations, as this would require overriding Magento core .phtml files — something we strongly advise against in extension development. Many free and paid Buy Now modules override core files, which can lead to maintenance and upgrade issues.

If you need the button in one of these places, add it to your own theme's template with the snippet below.

# Add Buy Now in custom template

To add the button to a custom product template, use the following code snippet:

```php
$buyNowBtnHtml = $block->getLayout()
    ->createBlock(\Mageprince\BuyNow\Block\Product\ListProduct::class)
    ->setProduct($_item)
    ->setTemplate('Mageprince_BuyNow::buynow.phtml')
    ->toHtml();
echo $buyNowBtnHtml;
```

- **Change `$_item` to the current product object.**
- **Hyvä theme:** use the template `Mageprince_BuyNow::hyva/buynow.phtml` instead. It renders a Hyvä-styled button (`btn btn-primary`).
- **Button title:** the button uses the title set in the admin configuration. To override it for one placement, add `->setButtonTitle('Your title')` before `->toHtml()`.
- **Don't place it inside another form.** The snippet renders its own `<form>`, and HTML forms cannot be nested. Put it outside the add to cart form, for example after its closing `</form>` tag. On Hyvä, the whole product item in product lists and sliders is a `<form>`, so place the snippet outside the item.

The screenshot below shows how to use the code in a Luma template.

**Sample template:** _vendor/magento/module-catalog/view/frontend/templates/product/list/items.phtml_

<img src="https://github.com/mageprince/magento2-buynow/assets/24751863/5ad4baf6-5897-4ea4-adda-8244126524c3" width="500"/>


# 🤝 Contribution

Want to contribute to this extension? The quickest way is to <a href="https://help.github.com/articles/about-pull-requests/">open a pull request</a> on GitHub. Contributions are welcome and are accepted under the MIT License.

# 🛠 Support

If you encounter any problems or bugs, please <a href="https://github.com/mageprince/magento2-buynow/issues">open an issue</a> on GitHub.

# 📸 Screenshots

### Product view page

<img width="687" alt="Product List Page" src="https://github.com/mageprince/magento2-buynow/assets/24751863/02ca3bcf-76cf-4226-bc57-9618e765abb7">

### Product list page

<img width="687" alt="Product List Page" src="https://github.com/mageprince/magento2-buynow/assets/24751863/dfb6ac6c-dcde-4103-b0ab-497971763eef">

### Custom product template with buy now code

<img width="687" alt="Custom Product Template" src="https://github.com/mageprince/magento2-buynow/assets/24751863/cce268e2-e2ea-465b-82ca-afc3e0f8d209">

# 📄 License

This extension is open source and released under the [MIT License](LICENSE).
