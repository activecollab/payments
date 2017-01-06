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

## Working with Addresses

## Address Interfaces

`ActiveCollab\Payments\Address\AddressInterface` describe an address. It can be used to define an address of an organization, or of an individual. In case of organizations, we can also keep track of tax ID, for invoicing purposes.

## Addresses Interfaces

`ActiveCollab\Payments\Address\AddressesInterface` is used to handle situations where addressible object can have more than one address. For example, a merchant can have multiple locations, or it can change primary location at some point in time. Not having other addresses, or lossing info about previous addresses may not be acceptible, so we have to keep track about all addresses associated with the object.

Addresses interface can be combined with of following interfaces, when we want to specify a default address:

1. `ActiveCollab\Payments\Address\OptionalDefaultAddressInterface` when default address is optional,
1. `ActiveCollab\Payments\Address\RequiredDefaultAddressInterface` when default address is required.

## To do:

1. Subscription change should have the new total and new items.