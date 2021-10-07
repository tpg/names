# Domains Reseller CLI
A command-line tool for domains.co.za resellers.

## Installation
```
composer global require thepublicgood/names
```

Once the package is installed, you can run the simple installer command:

```
names install <domains_api_token>
```

Insert your domains API token.

# Usage

## Fetching domain list
```
names domains:list
```

## Search by name
```
names domains:list --search "search"
```

## Sort by expiry date
```
names domains:list --expiry
```

## Fetch a list of expiring domains
```
names domains:expiring
```

## Checking if a domain is available
```
names domains:check "domain.com"
```

# Caches
Names will cache unique responses for up to 1 hour. You can refresh a response at any time by using the `--refresh` option, or by using the `cache:clear` command:

```
names cache:clear
```
