# 5.1.4
- Fix: version validation of dependencies
- 
# 5.1.3
- New: Added new examples of pix split to Efí SDK

# 5.1.2
- Fix: Compatibility with PHP >= 7.2

# 5.1.1
- Add: New examples of pix split

# 5.1.0
- Updated: Variable "valorDevolucao" changed to "valor" and "identificadorPagamento" is sent as a parameter in method "ofDevolutionPix()"

# 5.0.2
- Add: New example of create charge history

# 5.0.1
- Fix: Certificate verification
- Add: New example of pix devolution Open Finance

# 5.0.0
- Fix: psr-4 autoloading standard
- Fix: Method pixSend() now requires sending the Id
- Updated: attribute "pix_cert" on credentials has been renamed to "certificate"
- Updated: Method "oneStep()" renamed to "createOneStepCharge()"
- Updated: Method "payCharge()" renamed to "definePayMethod()"
- Updated: Method "resendBillet()" renamed to "sendBilletEmail()"
- Updated: Method "chageLink()" renamed to "defineLinkPayMethod()"
- Updated: Method "createChargeBalanceSheet()" renamed to "defineBalanceSheetBillet()"
- Updated: Method "updateParcel()" renamed to "updateCarnetParcel()"
- Updated: Method "cancelParcel()" renamed to "cancelCarnetParcel()"
- Updated: Method "resendCarnet()" renamed to "sendCarnetEmail()"
- Updated: Method "resendParcel()" renamed to "sendCarnetParcelEmail()"
- Updated: Method "getPlans()" renamed to "listPlans()"
- Updated: Method "paySubscription()" renamed to "defineSubscriptionPayMethod()"
- Updated: Method "pixSendList()" renamed to "pixDetailReceived()"
- Updated: Method "pixDevolutionGet()" renamed to "pixDetailDevolution()"
- Updated: Method "pixGetWebhook()" renamed to "pixDetailWebhook()"
- Updated: Method "pixLocationCreate()" renamed to "pixCreateLocation()"
- Updated: Method "pixLocationGet()" renamed to "pixDetailLocation()"
- Updated: Method "pixLocationDeleteTxid()" renamed to "pixUnlinkTxidLocation()"
- Updated: Method "pixListBalance()" renamed to "getAccountBalance()"
- Updated: Method "pixUpdateSettings()" renamed to "updateAccountConfig()"
- Updated: Method "pixListSettings()" renamed to "listAccountConfig()"
- Add: Certificate support in .p12 format
- Add: Pix due charge creation endpoints
- Add: Sent Pix management endpoints
- Add: Conciliation report endpoints
- Add: Open Finance API endpoints
- Add: Billet payment API endpoints
- Add: Method sendLinkEmail() for sending the payment link to the desired email
- Add: Method sendSubscriptionLinkEmail() for sending the subscription associated with a payment link to the desired email
- Add: Method createOneStepLink() to create a one-step payment link
- Add: Method createOneStepSubscription() to create a one-step subscription
- Add: Method createOneStepSubscriptionLink() for creating a one-step subscription link

# 4.1.1
- Fix: Verification of certificate expiration date
- Fix: Certificate path verification

# 4.1.0
- Fix: Bug checking in the requests to return the fail in "catch"
- Fix: Directory from composer autoload
- Fix: Printing error. Don't necessary "throw new Error()"

# 4.0.2
Removed: Unused function
Removed: Unused dependece 

# 4.0.1
Fix: failure check in the requests

# 4.0.0
Updated: Guzzle version v7 and PHP 7.2
Fix: Improvements in code organization and indentation.

# 3.1.0
- Added: New endpoint pix (Create Evp)
- Added: New endpoint pix (List Evp)
- Added: New endpoint pix (Delete Evp)
- Added: New endpoint pix (Update Settings)
- Added: New endpoint pix (List Settings)
- Added: New endpoint pix (List Balance)
- Added: Function to define the endpoints file
- Fix: Fefinition of timeout in settings
- Fix: Fet default value in the map function
- Updated: Field description "solicitacaoPagador"

# 3.0.0
- Added: api Pix
- Fix: updated dependencies

# 2.4.1

- Fix: Files with endpoint oneStep charge

# 2.4.0

- Added: new endpoint (oneStep charge)

# 2.3.0

- Added: new endpoint (settle charge)
- Added: new endpoint (settle carnet parcel)

# 2.2.0

- Added: new endpoint (create charge balance sheet)

# 2.1.0

- Added: new endpoint (update plan)
- Added: new endpoint (create subscription history)

# 2.0.0

- Breaking change: Drop PHP 5.4 support 
- Breaking change: Update Guzzle version

# 1.0.14

- Added: timeout option

# 1.0.13

- Fix: code climate on dev dependencies

# 1.0.12

- Added: new endpoint (update charge link)

# 1.0.11

- Added: new endpoint (charge link)
- Updated: docs

# 1.0.10

- Added: new endpoints (cancel carnet and cancel parcel)
- Updated: docs

# 1.0.9

- Fix: Tests.

# 1.0.8

- Updated: Request
- Added: User can define the certified path.

# 1.0.7

- Updated: ApiRequest
- Updated: Request
- Fix: Remove random number from detailSubscription example.

# 1.0.6

- Add: Add Support to PHP 5.4 and above

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
