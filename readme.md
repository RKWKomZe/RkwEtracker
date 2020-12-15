# Usage with Cookie-Consent-Tool
When using a Cookie-Consent-Tool you have to use a timeout for enabling cookies, because the eTracker-Script is loaded asynchronous and thus the relevant script-methods won't be available directly.

**Example:**

```
function waitForEtracker(){
    if(typeof _etracker !== "undefined"){
        _etracker.enableCookies(rkwEtrackerDomain);
        console.log('eTracker: cookies enabled');
    } else{
        setTimeout(waitForEtracker, 250);
    }
}
waitForEtracker();
```