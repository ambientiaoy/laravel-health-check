# Health Check for Laravel
## Installation
1. Copy the package contents to your Laravel app root in `packages/ambientia/health-check` directory.
2. Edit the Laravel app's `composer.json` file's autoload section:
```
     "autoload": {
         "psr-4": {
            "App\\": "app/"
+            "Ambientia\\HealthCheck\\": "packages/ambientia/health-check/src"
         },
```
3. Run `composer dump-autoload` in the app root
4. Edit `config/app.php`, add the service provider
```
         /*
          * Package Service Providers...
          */
+        Ambientia\HealthCheck\HealthCheckServiceProvider::class,

```
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
