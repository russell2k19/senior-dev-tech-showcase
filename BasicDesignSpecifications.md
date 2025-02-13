# HarveyNorman_PromotionalProducts

[![HarveyNorman_PromotionalProducts](https://img.shields.io/badge/version-1.0.0-green.svg)](https://github.com/AndreaAndreoli/senior-dev-tech-showcase)
[![Wiki Status](https://img.shields.io/badge/wiki-partially-yellowgreen.svg)](https://github.com/AndreaAndreoli/senior-dev-tech-showcase)
[![Package](https://img.shields.io/badge/package-1.0.0-blue.svg)](https://github.com/AndreaAndreoli/senior-dev-tech-showcase)


### This extension features Promotional Products with RabbitMQ and ElasticSearch integration.

<table>
    <caption>User stories</caption>
    <tbody>
    <tr>
        <td><b>Epics Impacted</b></td>
        <td><b>Actor</b></td>
        <td><b>User Story</b></td>
        <td><b>Action</b></td>
        <td><b>Acceptance</b></td>
    </tr>
    <tr>
        <td>Promotional Product Page</td>
        <td>Guest or <br>
            Registered User
        </td>
        <td>I want to be able to access a landing page that lists all Active Promotional Products of the website.
        </td>
        <td>When I navigate to the Promotional Product page of the website</td>
        <td>I will see all the Active Promotional Products with discounted price with Grid or List type display option</td>
    </tr>
    <tr>
        <td>Catalog Search</td>
        <td>Guest or <br>
            Registered User
        </td>
        <td>I want to be able to search Promotional Products of the website.
        </td>
        <td>When I search for keywords such as promo, promotional, sale, discount, discounted, or product sku of the website</td>
        <td>I will see relevant search results that includes Promotional Products</td>
    </tr>
    <tr>
        <td>Magento Admin Panel</td>
        <td>Admin User</td>
        <td>I want to see All Promotional Products in the admin.</td>
        <td>When I navigate to Marketing -> Promotional Products</td>
        <td>I will see a grid for all Promotional Products with columns for ID, SKU, Name, Price and Promotion Status  
        </td>
    </tr>
    <tr>
        <td>Magento Admin Panel</td>
        <td>Admin User</td>
        <td>I want to create a new Promotion in Admin</td>
        <td>When I navigate to Marketing -> Manage Promo in the admin</td>
        <td>I will be able to create ad manage any Promotion with no issues 
        </td>
    </tr>
    <tr>
        <td>Magento Admin Panel</td>
        <td>Admin User</td>
        <td>I want to set a Promotional Product in Admin</td>
        <td>When I edit the product and select a promo from dropdown selector in the admin</td>
        <td>I will find the newly created Promotional Product after the consumer process is completed 
        </td>
    </tr>
    <tr>
        <td>Magento Admin Panel</td>
        <td>Admin User</td>
        <td>I want to be able to add Promotional Products to CMS Page or Blocks</td>
        <td>When I add the Promotional Product Widget in Contents -> Elements</td>
        <td>I will see Promotional Products List for the corresponding Page or Block
        </td>
    </tr>
    <tr>
        <td>Magento CLI</td>
        <td>SSH user</td>
        <td>I want to be able to manually trigger RabbitMQ queue processing</td>
        <td>When I run the CLI command</td>
        <td>Queued promotional products sent by RabbitMQ custom publisher will be processed
        </td>
    </tr>
    </tbody>
</table>

## Technical Scope Details:
### Backend:
* Create a custom module PromotionalProducts
* Create a new menu item under Marketing called "Promotional Products"
* Implement a grid to display promotional products with columns for ID, SKU, Name, Price, and Promotion Status
    * Set a custom PromotionalProductCollection
    * Set none empty values for promotion_start_date as collection filter
    * Add capability to edit promotional products, including fields for promotion start/end dates and discount percentage
        * Set promotion_status = Enabled if promotion_start_date < current_date
        * Set promotion_status = Active if promotion_start_date >= current_date
    * Implement mass actions for enabling/disabling promotions
* Create a RabbitMQ custom Consumer to process product Promotions
* Create CLI command to manually trigger custom Broker for RabbitMQ
* Create RabbitMQ Custom Publisher to send product updates to queue when product is edited in Admin
    * See sample payload below
* Create Controller for custom fronted display of promotional products
* Implement Block method getActivePromotions() for storefront display
### Frontend:
* Create a new page to display promotional products
    * Create Layout, Block and Template files
    * Implement Grid or List type layout
* Add a widget that can be used to display promotional products on CMS pages or blocks

### Assumptions:
* Applies to All Products
* Admin Grid collumn 'Price' is the Discounted Price
* Promotional Product Status are below:
  * Enabled - (promo_start_date not satisfied) promotional product will not be displayed in the storefront
  * Active - (current date is satisfied between promo_start_date AND promo_end_date) promotional product is displayed in the storefront
  * Disabled - Promotional product will never be displayed in storefront
