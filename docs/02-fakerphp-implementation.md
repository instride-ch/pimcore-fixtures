## FakerPHP as DataProvider
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
