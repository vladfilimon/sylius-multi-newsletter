# sylius-multi-newsletter
1. Install with composer
   Add the following section to `composer.json`
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

2. Import routes

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
       - { resource: "@SyliusPayPalPlugin/Resources/config/config.yaml" }
   ```

3. Override Sylius' templates

    ```bash
    cp -R vendor/vladfilimon/sylius-multi-newsletter/src/Resources/views/bundles/* templates/bundles/
    ```

4. Apply migrations

   ```
   bin/console doctrine:migrations:migrate -n
   ```
## Screenshots
![alt text](https://github.com/vladfilimon/sylius-multi-newsletter/blob/main/docs/screenshots/newsletter_admin_list.png?raw=true)
![alt text](https://github.com/vladfilimon/sylius-multi-newsletter/blob/main/docs/screenshots/newsletter_admin_edit.png?raw=true)
![alt text](https://github.com/vladfilimon/sylius-multi-newsletter/blob/main/docs/screenshots/newsletter_admin_customer_edit.png?raw=true)
![alt text](https://github.com/vladfilimon/sylius-multi-newsletter/blob/main/docs/screenshots/newsletter_customer_account.png?raw=true)
![alt text](https://github.com/vladfilimon/sylius-multi-newsletter/blob/main/docs/screenshots/newsletter_email.png?raw=true)
![alt text](https://github.com/vladfilimon/sylius-multi-newsletter/blob/main/docs/screenshots/newsletter_register.png?raw=true)

