# Health Check for Laravel

## Installation for development in a Laravel project
1. Clone this repository outside of your Laravel project directory
2. Edit the Laravel project's `composer.json` repositories section:
```
    "repositories": [
        {
            "type": "path",
            "url": "../health-check",
            "options": {
                "symlink": true
            }
        }
    ],
```
3. Run `composer update` in the app root

Now you have a symlink in `vendor/ambientia/health-check` that points to the original directory that you cloned in step 1.

## Using the health checks
You can set your monitoring system to ping the liveness and readiness URLs to get alerted if there are any problems.\
In Kubernetes and OpenShift you can use the probes also for container health checks.
### Liveness Probes
There are dedicated liveness probes for different services.\
They will response with http 200 status code if the service is up and functions without problems.\
Https status 503 is returned if the service is not available.
- Backend service: `{APP_URL}/health-check/liveness/backend`
- Database service: `{APP_URL}/health-check/liveness/database`
- Schedule service: `{APP_URL}/health-check/liveness/schedule`
- Queue service: `{APP_URL}/health-check/liveness/queue`
### Readiness Probe
Readiness probe is identical for all services: `{APP_URL}/health-check/readiness`\
It will response with http 200 status code if the service is ready to take http requests.
