## Take Home Assessment: A Simple Message Queue

[![Build Status](https://travis-ci.com/dambrogia/magento-assessment.svg?branch=master)](https://travis-ci.com/dambrogia/magento-assessment)

Please read the entire readme, there are necessary details throughout the entire document. Thank you.


### Instructions:
This is a 2.3.x Magento 2 CE installation with sample data. Please create a module with the namespace `Assessment\SimpleQueue` under `app/code`. This module should use a native [Magento Message Queue](https://devdocs.magento.com/guides/v2.3/extension-dev-guide/message-queues/message-queues.html) to dispatch a message including the sku of the product. This message needs to dispatch in two occasions:

- When a products page is viewed (don't worry about anything FPC related).
- Within a CLI command that takes a product entity id as an option|argument.

Within your consumer, log the sku inside the message to a file named `consumer.log`.

_Note: A MySQL queue is fine, AMQP/RMQ isn't necessary since the adapter/connection is abstracted._


Remember:
 - Keep it simple, stupid (KISS)
 - Single Responsibility Principle

___
### Local Environment:
When you run `composer install` all of the files you're used to seeing in an M2 repo will generate, they're intentionally omitted and ignored by git.

There is a local docker-compose environment available to you inside the [`.docker`](https://github.com/dambrogia/magento-assessment/tree/master/.docker) directory. There is also a very direct install script at `install.sh`. You are not required to use any of these, but when your code is reviewed this will be the environment it will be tested on. If you have a problem with the local environment, please open an issue on the repo.

##### A quick tid-bit on docker volumes:
If you do not run a linux desktop as your local machine, you will receive _much_ better performance using [mutagen](https://github.com/quodlibet/mutagen) to sync your files rather than docker's native volumes. There is a small comment with instructions in [`docker-compose.yml`](https://github.com/dambrogia/magento-assessment/blob/master/.docker/docker-compose.yml#L17)

##### Getting started:
You can view the [`.travis.yml`](https://github.com/dambrogia/magento-assessment/blob/master/.travis.yml) file to see how to spin up docker.
If you are unfamiliar with Travis, basically you need a composer auth.json file for the install, docker-compose (the install instructions there are for an ubuntu 16 travis-ci runner) and then you can boot your docker containers and complete the install of the local environment (xdebug included).

___
### How to work on this and submit it?

There are three options for submissions. My priority is to keep previous submissions hidden from new candidates. It saves me from wiping and recreating the repo after every assessment turned in.

You can:
- Clone this repo, remove the `.git` directory create your own repo and send the link to that repo.
- Fork this repo to a _private_ repository and provide access to your private fork
- Clone this repo, branch off of master (`git checkout -b assessment/<your-name>`) and push a branch (`git push origin assessment/<your-name>`) to the origin _without making a PR_.

### _Please do not create a PR on this repository._ I can delete branches, I can not delete PRs.

Please edit the instructions within the final section of this readme file so I know how to run and test your code. This is similar to the process we have for PRs.

___
### What am I being assessed for?
The quality of your code will be reviewed including code style, readability, performance, security and best practices. Functionally this is a pretty straight forward pass/fail assessment but there are enough moving pieces to show your attention to detail. Please follow PSRs: 3, 4 and 12.

To be very transparent, attention to detail and thoroughness are the most sought after remarks. Are your instructions clear? Do you comment your code in complex areas? Is your formatting consistent? Did you lint your code? Do you have errors when I try to install?

What you submit should be _very_ straight forward to test and confirm that it works. If this simple assessment can't be rolled out efficiently, it only makes sense that your production rollouts will only be more challenging. On the flip side, if you pay attention to detail and this can be tested mindlessly, you probably have a good idea of how to contribute efficiently.

On the other hand, this is only an assessment and this code will never reach a production environment. Your time is valuable and very much appreciated. If you can cut a corner and save upwards of 20-30 minutes, write a comment on why you did what you did and how it could be better/more in-depth if you had more time.
___
### Instructions:
Add step by step instructions here on how to mindlessly test through your module.
