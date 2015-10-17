# Payments

[![Build Status](https://travis-ci.org/activecollab/payments.svg?branch=master)](https://travis-ci.org/activecollab/payments)

Prepare orders and receive payments. _Concept and exploration. We'll see where it will lead us._

Order lifecycle events:

1. Completed,
2. Partially refunded,
3. Fully refunded.

Subscription lifecycle events:

1. Activation,
2. Successful rebill,
3. Failed rebill,
4. Change,
5. Deactivation.

When gateway listens to notifications from the gateway service, it should use `ActiveCollab\Payments\Dispatcher` instance
to dispatch events so application can react to these order and/or subscription changes.

## To do:

1. Subscription change should have the new total and new items.