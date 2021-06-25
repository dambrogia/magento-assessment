# README #

This module Publishes messages to defined topic, and consumers which consume topic 
and log product SKU via a DB Queue Consumer when a product is viewed or upon execution of the CLI command.

Default Behavior
Navigate to a product page, will result in an entry like example below
````
tail /var/www/html/var/log/consumer.log
...
[2021-06-25 04:20:21] consumerLogger.INFO: Product Sku: 24-MB01 [] []
[2021-06-25 04:21:00] consumerLogger.INFO: Product Sku: 24-WG086 [] []
````

Cli-Command for testing
````
WORKDIR /var/www/html
bin/magento simple:queue:publish -h
Description:
  Publish Product Entity Id to Consumer Queue for processing!

Usage:
  simple:queue:publish <entity_id>

Arguments:
  entity_id             Product Entity ID

Usage Examples:
bin/magento simple:queue:publish <entity_id>
bin/magento simple:queue:publish 12
bin/magento simple:queue:publish 47
bin/magento simple:queue:publish 24
````

FrontEnd links for testing
```
http://localhost:3005/go-get-r-pushup-grips.html
http://localhost:3005/dual-handle-cardio-ball.html
http://localhost:3005/harmony-lumaflex-trade-strength-band-kit.html
http://localhost:3005/affirm-water-bottle.html
```
