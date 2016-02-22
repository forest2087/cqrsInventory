# CQRS Inventory Proof of Concept with Laravel and AngularJs

This app is a proof of concept of a simple inventory system designed with CQRS design pattern with event sourcing.

 
# What it does: 

1. Add an item to the inventory:
When I add a new item to the inventory
Then inventory contains information about the newly added item, such as Label, Expiration, Type.

2. Take an item from the inventory by Label:
When I took an item out from the inventory
Then the item is no longer in the inventory

3. Notification that an item has been taken out:
When I took an item out from the inventory
Then there is a notification that an item has been taken out.

4. Notification that an item has expired:
When an item expires
Then there is a notification about the expired item.


# Installation

Clone repo.

Copy .env.example to .env

	composer update
	
	npm install
	
	gulp
	
	php artisan migrate:install  //database using sqlite file
	
	php artisan db:seed

# Test

	phpunit

# Run

	php artisan serve
	
	http://localhost:8000

# To be improved

Due to time constraint, this is an app with very simple back end api with no auth + angularjs frontend. 

Repository and Interface should be implemented to abstract the database layer from the service logic layer for better extensibility. 

OAuth/JWT or some sort of authentication should be implemented for security and third-party application access. 

Queue should be implemented for store commands when scaling. 

Write locks should be implemented for read/write conflicts.

Functional tests should be written for the controllers. 

Phpunit.xml should be implemented for better configuration of the unit tests. 

NoSql database can be used for better event sourcing. 
