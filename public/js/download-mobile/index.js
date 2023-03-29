const appStoreUrl = 'https://apps.apple.com/us/app/ozim-platform/id1588247100'
const googlePlayUrl = 'https://play.google.com/store/apps/details?id=com.ozim.platform'

const appStoreImg = 'img/appstore.svg'
const googlePlayImg = 'img/googleplay.svg'

window.onload = function() {
    var osType = getMobileOperatingSystem()
    if (osType == "Android"){
        reroute(googlePlayUrl)
    }
    else if (osType == "iOS"){
        reroute(appStoreUrl)
    }
}

function reroute(url) {
    window.location.href = url
}

function onAppStoreClick(){
    reroute(appStoreUrl)
}

function onGoogleplayClick(){
    reroute(googlePlayUrl)
}

function getMobileOperatingSystem() {
    var userAgent = navigator.userAgent || navigator.vendor || window.opera;
    if (/windows phone/i.test(userAgent)) {
        return "Windows Phone";
    }
    if (/android/i.test(userAgent)) {
        return "Android";
    }

    if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
        return "iOS";
    }

    return "unknown";
}