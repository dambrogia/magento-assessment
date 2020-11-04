## Take Home Project: A Simple Message Queue

____

#### Explanation:

A Magento 2.2.3 repository exists at `github.com/dambrogia/magento-project-sample-queue.git`. Clone this repository. There's a fairly empty module at `app/code/Sample/SimpleQueue` that is meant for you to complete this example queue. Make sure to hook up all the tests in there.

You are responsible for your own docker/vagrant/local environment. Since you're applying for a Magento 2 position, the throught is that you have an existing  Magento local environment at your disposal. When you push your code, a fresh 2.2.3 with sample data will run tests through Travis-CI. You are not responsible for providing any other infrastructure or deployment than your local env and pushing your code.

Build a simple message queue that will dispatch a message when a product page (PDP) is viewed. The message payload must include the sku of the product. Consume the messages in the queue and log the sku in the payload to a log named `consumer.log`.
___
That's it! It's _very_ straight forward and intended to be. There's a lot of places in this small modules where you can prove your knowledge of OOP and SRP. With this small of a scope, there's also a lot of places where you can cut corners and finish this as quickly as possible. Find a balance of finishing in a realistic deadline while also providing a good example of your skills.

I'll look at your code quality including code style,

_Note: A MySQL queue is fine, AMQP/RMQ isn't necessary since the adapter is abstracted._
____

##### Requirements
 - Dispatch message containing product sku when product page is visited.
 - Consume message from queue, log sku to `consumer.log`
 - All unit/integration tests must pass (they run automatically when you push to your branch).
 - Functionality must work on a clean 2.3.3 install with sample data.
 - Compliant with PSR-3, PSR-4, PSR-12
 - Commit a PR into the main branch when you finish. It will not be merged, but rather allow for visibility into changes from the base branch.
