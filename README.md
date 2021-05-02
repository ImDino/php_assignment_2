# PHP assignment 2

## Part 1

* Create a RESTful API that generates 20 different products.

* It should resemble the following API:
https://webacademy.se/fakestore/

**Product example**
```javascript
{
    "id": 1,
    "title": "Fjällraven Backpack",
    "description": "Your perfect pack for everyday use and walks in the forest."
    "image": "https://picsum.photos/500?random=1",
    "price": 109.95,
    "category": "men clothing"
}
```

## Part 2

*note the /v2 path.*

* The user should be able to get X amount of random items...
https://webacademy.se/fakestore/v2/?show=5

* and also search for specific categories.
https://webacademy.se/fakestore/v2/?category=jewelery

* Implement security optimizations.
https://webacademy.se/fakestore/v2/?category=foo&show=100

**Demo**
```javascript
[
    {
        "Category": "Category not found"
    },
    {
        "Show": "Show must be between 1 and 20"
    }
]
```

* Publish your API on [Heroku](https://heroku.com/).


## Result

*NOTE: Using JSON_PRETTY_PRINT for demonstration purposes.*

* [All items](https://php-assignment-2-dino.herokuapp.com/) *'/v2' can do the same w/o queries*
* [Specific category](https://php-assignment-2-dino.herokuapp.com/v2/?category=headphones)
* [Two random items](https://php-assignment-2-dino.herokuapp.com/v2/?limit=2)
* [Both](https://php-assignment-2-dino.herokuapp.com/v2/?category=headphones&limit=2)

Security optimizations:
* [Non existing category](https://php-assignment-2-dino.herokuapp.com/?category=headph)
* [Invalid limit](https://php-assignment-2-dino.herokuapp.com/?limit=0)
* [Both](https://php-assignment-2-dino.herokuapp.com/?category=headph&limit=0)