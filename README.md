# Stripe SDK Example
I love Stripe, but I noticed that their newest docs appeared to be lacking some fairly obvious uses, so I decided to add a basic example showing how to create a customer, add them to a subscription plan, and get the invoice information.

All of the code is in the index.php, if you want to run the code, change the STRIPE_KEY environment variable in docker-compose.yml to match your own TEST Stripe secret key, then run:

```shell
composer install --ignore-platform-reqs
docker-compose up
```

The index script will be available at http://localhost:10000
