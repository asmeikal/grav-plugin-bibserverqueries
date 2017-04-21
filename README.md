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

To query the Bibserver, use the Twig function `bibserver_query(query, url='query')`.
The `query` parameter specifies the query to be sent to the Bibserver, _e.g_, a list of keys if `url` is `key-list`, or a standard MongoDB query (as an associative array) if `url` is the default `query`.
The `url` parameter specifies to which `url` the query will be sent.

