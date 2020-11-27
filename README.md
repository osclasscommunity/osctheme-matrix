# Project archived

Working on a new premium theme using the Matrix base. https://github.com/dftd

# Matrix

## Info

This is a *WIP* Osclass theme that's based on Bender 3.2.0.

## Current progress

- Check https://github.com/osclasscommunity/osctheme-matrix/commits/develop.
- Finished frontend for homepage, login (forgot password), register, contact, my account (items, profile, alerts), public profile and item page.
- Working on item post page.

## What's left

- Item publish/edit page.
- Search page.
- Integration with plugins and admin configuration.
- Polishing a lot of stuff.

![Current progress](https://i.postimg.cc/4yRQGcdb/some-progress-html-css.jpg)

## Dependencies

* [Node.js](http://nodejs.org/)
* [Sass](http://sass-lang.com/)

Once you have the dependencies installed, run the following command:

```
$> npm install
```

## Watch changes

You can compile Sass files automatically every time they're changed by executing the following command:

```
$> grunt watch:matrix
```

## Build

```
$> grunt dist:matrix
```

Generate a `.zip` file that you can import in Osclass.
