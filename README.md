# TehlaPumlBundle
Create PlantUML schemes

## Configuration :

### with JRE and Graphviz library :
```
tehla_puml:
    converter: 'jar'
    converter_path:
        jar: /absolute/path/to/plantuml.jar # default : the one into this bundle

``` 
### with HTTP PLANTUML server :
```
tehla_puml:
    converter: http
    converter_path:
        http: http://plantuml-url #see https://github.com/plantuml/plantuml-server
```

### In order to generate Assets mith a custom maker : 

```
tehla_extension:
    component:
        maker_twig: true
        maker_generator: 
            - Tehla\PumlBundle
```



## Asset :

Plantuml is a "markdown" language, offering technical implementation for UML drawing.
Official guide : http://plantuml.com/fr/guide


Assets are used to modelize the elements of the scheme. They are used to : 
- bind themselves by their name or id each other
- wrap other assets

Assets are classifed into `Asset\<Language>` directory.
Depending on what we expect on them, they should implements one of these 2 interfaces :
- `BuildInterface` : to convert object properties into PlantUML markdown language
- `WrapperInterface` : to wrap object into larger object element

The `Rendereris a specific Wrapper used as the starting point (the blank page) of your scheme.

## Conversion :

This bundle use `MarkdownToPngInterface` to convert data into an `\SpliFileInfo` image.
2 implementations are available to do this : 
- from a jar (a default one is available)
- from a PlantUML HTTP API


 
## Maker :

A maker is available to extends the Asset pool of this bundle.

__Command__ : `bin/console tehla:make:puml_asset langage1 [langage2 ...]`

2 files are parsed into `Resources\views\<Language>` :
* `dictionnary.yaml` : custom parameters used to define the required assets
* `template.twig` : TWIG template to convert dictionnary values into `Asset\<Language>` classes



