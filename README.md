# sylius-multi-newsletter
1. To install this package with composer, copy the following section to your project's `composer.json`
```
    "repositories": [
        {
            "type": "vcs",
            "url":  "git@github.com:vladfilimon/sylius-multi-newsletter.git"
        }
    ]
```
Then do `composer require vladfilimon/sylius-multi-newsletter`
register the bundle in `config/bundles.php`
```
[
    ...
    VladFilimon\MultiNewsletterPlugin\VladFilimonMultiNewsletterPluginBundle::class => ['all' => true],
];
```

2. Import the routes

    ```yaml
    # config/routes.yaml
    sylius_resource:
        resources:
            app.multinewsletter:
                driver: doctrine/orm # You can use also different driver here
                classes:
                    model: VladFilimon\MultiNewsletterPlugin\Entity\Newsletter
    ```

3. Import configuration

   ```yaml
   # config/packages/_sylius.yaml

   imports:
       # ...
       - { resource: "@VladFilimonMultiNewsletterPluginBundle/Resources/config/config.yml" }
   ```

3. Override Sylius' templates

    ```bash
    cp -R vendor/vladfilimon/sylius-multi-newsletter/src/Resources/views/bundles/* templates/bundles/
    ```

4. Apply migrations

   ```
   bin/console doctrine:migrations:migrate -n
   ```
##Sending newsletters
Because we rely on Sylius mail sender in order to send the newsletters, each new newsletter needs a twig template, and registration for the sylius_mailer.
This bunlde comes with a newsletter template for being subscribed, if you need other templates, register them in `sylius_mailer.yaml` like this:
```
sylius_mailer:
    emails:
      NEWSLETTER_TEMPLATE_KEY:
      template: "path_to_my_template.html.twig"
```
To send a newsletter you need to run

`bin/console newsletter:send NEWSLETTER_ID NEWSLETTER_TEMPLATE_KEY`

This provides just minimal functionality. No batch processing, AMQP, no retrying mechanism, semaphores etc.

To run the example sending of newsletter, create a newsletter in the admin, assign some shop users to it (on the admin newsletter edit page) get it's id and run

`bin/console newsletter:send NEWSLETTER_ID newsletter_template`
## Screenshots
There screenshots are outdated and lack translations
![alt text](https://github.com/vladfilimon/sylius-multi-newsletter/blob/main/docs/screenshots/newsletter_admin_list.png?raw=true)
![alt text](https://github.com/vladfilimon/sylius-multi-newsletter/blob/main/docs/screenshots/newsletter_admin_edit.png?raw=true)
![alt text](https://github.com/vladfilimon/sylius-multi-newsletter/blob/main/docs/screenshots/newsletter_admin_customer_edit.png?raw=true)
![alt text](https://github.com/vladfilimon/sylius-multi-newsletter/blob/main/docs/screenshots/newsletter_customer_account.png?raw=true)
![alt text](https://github.com/vladfilimon/sylius-multi-newsletter/blob/main/docs/screenshots/newsletter_email.png?raw=true)
![alt text](https://github.com/vladfilimon/sylius-multi-newsletter/blob/main/docs/screenshots/newsletter_register.png?raw=true)

