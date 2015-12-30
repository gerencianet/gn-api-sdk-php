# 1.0.5

- Updated: ApiRequest

# 1.0.4

- Added: new endpoints (carnet history, resend parcel and resend carnet)
- Updated: docs

# 1.0.3

- Fix: endpoint charge history

# 1.0.2

- Added: new endpoint (charge history)
- Added: custom header
- Updated: docs

# 1.0.1

- Added: new endpoint (resend billet)
- Updated: docs

# 1.0.0

- First stable version

# 0.2.3

- Updated: docs
- Updated: code examples

# 0.2.2

- Changed: Gerenciant's urls for production and sandbox

# 0.2.1

- Refactored: now Gerencianet endpoints are restfull, which means that the sdk must consider sending also put and delete
- Refactored: each function now has two arguments: *params* and *body*.
              The *body* is meant to be sent in the request body as usual, whereas the *params* will be mapped to url params as defined in gn-constants. If the param is not present in the url, it will be sent as a query string
- Updated: docs

# 0.1.1

- Added: createPlan and deletePlan
- Updated: docs

# 0.1.0

- Initial release
