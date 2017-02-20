# Miya Analytics

[![Build Status](https://travis-ci.org/miya0001/miya-analytics.svg?branch=master)](https://travis-ci.org/miya0001/miya-analytics)

A WordPress plugin which output the code of the Google Analytics.

* Compatible with [Content Secutiry Policy](https://developer.mozilla.org/en-US/docs/Web/HTTP/CSP).
* No admin, put tracking ID ad a code. :)

## How to Activate

Add a tracking ID of the Google Analytics like following.

```
add_filter( 'miya_analytics_tracking_id', function() {
	return 'xxxx'; // Your tracking ID.
} );
```
