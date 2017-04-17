# Bibserver Queries Plugin

The **Bibserver Queries** Plugin is for [Grav CMS](http://github.com/getgrav/grav). Its intended usage is to make queries to the MCLab Bibserver from Grav pages, and to make available the result of the queries inside the template.

## Installation

<!--
Installing the Bibserver Queries plugin can be done in one of two ways. The GPM (Grav Package Manager) installation method enables you to quickly and easily install the plugin with a simple terminal command, while the manual method enables you to do so via a zip file.

### GPM Installation (Preferred)

The simplest way to install this plugin is via the [Grav Package Manager (GPM)](http://learn.getgrav.org/advanced/grav-gpm) through your system's terminal (also called the command line).  From the root of your Grav install type:

    bin/gpm install bibserverqueries

This will install the Bibserver Queries plugin into your `/user/plugins` directory within Grav. Its files can be found under `/your/site/grav/user/plugins/bibserverqueries`.

### Manual Installation
-->

To install this plugin, just download the zip version of this repository and unzip it under `/your/site/grav/user/plugins`. Then, rename the folder to `bibserverqueries`.

You should now have all the plugin files under

    /your/site/grav/user/plugins/bibserverqueries
	
> NOTE: This plugin is a modular component for Grav which requires [Grav](http://github.com/getgrav/grav) to operate.

## Configuration

Before configuring this plugin, you should copy the `user/plugins/bibserverqueries/bibserverqueries.yaml` to `user/config/plugins/bibserverqueries.yaml` and only edit that copy.

To configure the plugin, edit the `bibserverqueries.yaml` file and set the base `url` of the Bibserver you will be querying, and the OAuth `token` for said Bibserver.

```yaml
enabled: true
token: [OAuth token]
url: [Bibserver base url]
```

## Usage

To query the Bibserver, insert the following inside the frontmatter of a page:

```yaml
bibserver:
    query_url: [query url]
    query:
        [query]
```

- `query_url` is optional (defaults to `query`), and identifies the URL to which the query will be directed.
- `query` field is required and specifies the query to use, _e.g._, to query for a list of keys one can specify:

  ```yaml
  bibserver:
    query_url: 'key-list'
    query:
        - [key 1]
        - [key 2]
        ...
  ```

  To issue a MongoDB query:

  ```yaml
  bibserver:
    query_url: 'query'
    query:
        author:
            $regex: [Author Name]
  ```

> NOTE: This plugin currently only works inside non-modular pages.

