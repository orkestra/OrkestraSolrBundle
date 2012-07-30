OrkestraSolrBundle
==================

OrkestraSolrBundle allows for mapping objects to Solr documents. The bundle is targeted toward Symfony 2.0 support
intially.

**NOTE:** This bundle is under active development. Expect BC breaks often.

Pre-requisites
--------------

This bundle requires the Solr extension. See www.php.net/Solr for more information.

Installation
------------

1.  Register the bundle in AppKernel

2.  Update your autoloader

3.  Configure the bundle

```
# config.yml
orkestra_solr:
  connection:
    hostname: localhost
    port: 8443
    username: user
    password: pass
  auto_mapping: true
  mappings:             # Currently not implemented, manually specify mapping configurations
    - { driver: annotation, path: %kernel.root_dir%/../vendor/bundles/Acme/AcmeDemoBundle/Entity }
```


To-do
-----

-   XML and Annotation support

-   Object hydration abstraction

    -   Allow for custom object hydration, like doctrine entities

-   QueryBuilder-type API
