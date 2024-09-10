## Usage

First, you will need to declare the src path to your fixtures in config/services.yaml.
All classes will be registered with the fixture tag, which then will be loaded by the Instride\PimcoreFixturesBundle\Test\PimcoreTestCase.php class in the setUp() method.
```
    App\DataFixtures\:
        resource: '%kernel.project_dir%/src/DataFixtures'
        tags: [ instride.pimcore.fixture ]
``` 

### Fixtures

To create a new fixture, you will need to create a new class in your earlier specified fixtures path and make it extend the Instride\PimcoreFixturesBundle\Fixture class.
By extending the Fixture class, you will have access to the Fixture::load() method. In here, you will create all data that you want to be loaded into the database.
When finished, you either return the single object that was created or an array of objects.

```
public function load(): Concrete|array
{
    $objects = [];
    $path = Service::createFolderByPath('/TestObjects');
    $object1 = new DataObject();
    $object1->setKey('Test Object 1');
    $object1->setName('Test DE', 'de_CH');
    $object1->setName('Test FR', 'fr_CH');
    $object1->setName('Test IT', 'it_CH');
    $object1->setPublished(true);
    $object1->setParent($pathToObjects);
    $objects[] = $object1->save();

    $object2 = new DataObject();
    $object2->setKey('Test Object 2');
    $object2->setName('Test DE 2', 'de_CH');
    $object2->setName('Test FR 2', 'fr_CH');
    $object2->setName('Test IT 2', 'it_CH');
    $object2->setPublished(true);
    $object1->setParent($pathToObjects);
    $objects[] = $object2->save();

    return $objects;
}

```

### Dependecies
If you want to save an object to later use it as relation in another object, you can use the FixtureRegistry::addFixture() method.
This will save the object in the registry and return it to you.
```
    $object1 = new DataObject();
    $object1->setKey('Test Object 1');
    $object1->setName('Test DE', 'de_CH');
    $object1->setName('Test FR', 'fr_CH');
    $object1->setName('Test IT', 'it_CH');
    $object1->setPublished(true);
    $object1->setParent($pathToObjects);
    $objects[] = $object1->save();
    
    FixtureRegistry::addFixture('object1', $object1);

```
In another Fixture, you can now use the object by calling the FixtureRegistry::getFixture() method.
```
    $object1->setRelation(FixtureRegistry::getFixture('object1'));
```

### Groups
If in your test, you only want to load some specific fixtures, you can use the FixtureAttributes.
Your Fixture will need to implement the Instride\PimcoreFixturesBundle\FixtureGroupInterface and implement the getGroup() Method.

Here, you will assign the Fixture to a group, which you can then use in your test to only load the fixtures that are in the specified group.
```
   #[FixtureGroups(['group1'])]
    public function testFixtureGroup1(): void {}

   #[FixtureGroups(['group1', 'group2'])]
    public function testFixtureGroup1And2(): void {}
```
