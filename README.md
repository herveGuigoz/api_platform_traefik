## Installation

### generated SSL certs

 Traefik need tls certificates to handle https request>

 - Install mkcert to generate local certs.
 - edit Makefile (certs command) with your desired domains.
 - run `make certs`

### create proxy network

- run `make network`

### build containers

- run `make install`

## How to

### Define service ports:

```yml
--traefik.routers.clientloadbalancer.server.port=3000
```

 The port specified to Træfik will be exposed by the container (here exposes the 3000 port), 
 but if your container exposes only one port, it can be ignored.

