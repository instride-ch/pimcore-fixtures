[//]: # (![Pimcore Fixtures Bundle]&#40;docs/images/github_banner.png "Pimcore Fixtures Bundle"&#41;)

[![Software License](https://img.shields.io/badge/license-GPLv3-brightgreen.svg?style=flat-square)](LICENSE.md)

## Introduction

The Pimcore Fixtures Bundle is a customized version of the DoctrineFixturesBundle, specifically adjusted to work seamlessly with Pimcore and phpunit. This bundle allows you to easily manage and load data fixtures into your Pimcore application, providing a robust and flexible way to set up and purge your test environments.

In the near future, we will introduce FakerPHP as a DataProvider to the bundle.
You will be able to create a config file for each class, where you specify which FakerProvider should be used for which field.
Mentioned config file will look something like this:

```
YourDataObject:
    firstName: 'firstNameMale|firstNameFemale'
    lastName: 'lastName'
    email: 'email'
    adress: 'address, city postcode'
             
```

In your fixture, you will then be able to use our DataProvider like this:
```
    $dataProviderFactory->generate(YourObject::class, $amount, $options = null);
```

In the options array, you can override any attribute while generating the data.
Example:
```
    $dataProviderFactory->generate(YourObject::class, $amount, [
        'firstName' => 'John',
        'lastName' => 'Doe',
        'email' => 'john.doe@email.com'
    ]);
```

## Further Information
* [Installation & Configuration](docs/00-installation-configuration.md)
* [Usage](docs/01-usage.md)

## License
**instride AG**, Sandgruebestrasse 4, 6210 Sursee, Switzerland  
connect@instride.ch, [instride.ch](https://instride.ch)  
Copyright © 2025 instride AG. All rights reserved.

For licensing details please visit [LICENSE.md](LICENSE.md) 
