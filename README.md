<p align="center">
    <a>
    <picture>
        <source media="(prefers-color-scheme: dark)" srcset="/branding/fw-logo-dark.svg">
        <source media="(prefers-color-scheme: light)" srcset="/branding/fw-logo.svg" />
        <img src="/branding/fw-logo.svg" width="200px" />
    </picture>
    </a>
</p>

<p align="center">
    <a href="https://github.com/interaapps/punyshort-frontend">Frontend<a>
    <span> - </span>
    <a href="https://github.com/interaapps/punyshort-backend">Backend<a>
    <span> - </span>
    <a href="https://github.com/interaapps/punyshort-redirect-proxy">Redirect Proxy<a>
</p>

<p align="center">
<img src="/screenshots/scr2.png" width="40%" />
<img src="/screenshots/scr1.png" width="40%" />
<img src="/screenshots/scr4.png" width="40%" />
<img src="/screenshots/scr3.png" width="40%" />
</p>

## Infrastructure
To run a Punyshort instance you need those components:
- **Backend**: This is the api. The brain of Punyshort. It will communicate with the database and handle everything.
- **Frontend**: This is what the user sees. An interface where you can shorten links, manage them, see the stats & more
- **Redirect Proxy**: This is a web server which communicates with the Backend and will redirect the users where they need to go.
- **MariaDB Database**: This is a database.


## Setting up a custom Redirect-Proxy
You might want to add a custom redirect proxy so the traffic goes through your servers and the SSL-Encryption and Domain managment is on your site. 

#### How do I set it up?
1. Go to https://punyshort.intera.dev
2. Log in -> Domains
3. 'Add Domain' -> Enter Domain Name and select as 'Domain Registration Type'  Custom Proxy
4. Create a TXT Entry for your domain named 'punyshort-check.{YOUR-DOMAIN}' and the value given in the Dashboard
5. Start an instance (We recommend you to let it go through a reverse proxy for SSLs)
```bash
docker run -p 80:80 \
  -e PUNYSHORT_BASE_URL='https://api.punyshort.intera.dev' \
  -e PUNYSHORT_ERROR_URL='https://punyshort.intera.dev/error-page' \
  -e PUNYSHORT_KEY='GIVEN API KEY ON THE DASHBOARD' \
  -e PUNYSHORT_IP_FORWARDING='true' \
  interaapps/punyshort-redirect-proxy
```

## Deployment
### docker-compose
```yaml
docker-compose up
```

### Running the Components independently
You can run all components independently. Use the docker images which are shown in the docker-compose or go to the specific repositories. You'll find the environment variables in the specific repositories as well.