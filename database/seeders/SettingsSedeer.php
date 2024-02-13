<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSedeer extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $baseUrl = env('APP_URL');

        $general_settings = [
            'isRTL' => 'false',
            'currency' => 'USD',
            'isAddShow' => 'true',
            'isChatShow' => 'true',
            'isInAppEnable' => 'true',
            'isVoiceEnable' => 'true',
            'isCameraEnable' => 'true',
            'isStripeEnable' => 'true',
            'isPaypalEnable' => 'true',
            'isRazorPayEnable' => 'true',
            'isGuestLoginEnable' => 'true',
            'email' => 'megabot@gmail.com',
            'isGoogleAdmobEnable' => 'true',
            'isChatHistoryEnable' => 'true',
            'isImageGeneratorShow' => 'true',
            'isCategorySuggestion' => 'true',
            'isTextCompletionShow' => 'true',
            'youtube' => 'Youtube',
            'about_us' => 'About Us',
            'linkedin' => 'Linkedin',
            'instagram' => 'Instagram',
            'site_name' => 'Megabot',
            'description' => 'Description',
            'twitter_url' => 'Twitter',
            'facebook_url' => 'Facebook',
            'phone_number' => 'Phone Number',
            'home_logo_url' => $baseUrl.'/admin/homeLogo.png',
            'paypal_status' => 'true',
            'privacy_policy' => 'Privacy Policy',
            'chatgpt_api_key' => 'Your Chatgpt API key',
            'drawer_logo_url' => $baseUrl.'/admin/drawerLogo.png',
            'free_chat_limit' => '5',
            'razorpay_status' => 'true',
            'splash_logo_url' => $baseUrl.'/admin/splashLogo.png',
            'terms&condition' => 'Terms & Condition',
            'paypal_client_id' => 'Your Paypal Client Id',
            'paypal_secret_key' => 'Your Paypal Secret Key',
            'razorpay_client_id' => 'Your Razorpay Client Id',
            'razorpay_secret_key' => 'Your Razorpay Secret Key',
            'stripe_client_id' => 'Your Stripe Client Id',
            'stripe_secret_key' => 'Your Stripe Secret Key',
            'revenuecat_ios_api_key' => 'Your Revenuecat Ios Api Key',
            'revenuecat_android_api_key' => 'Your Revenuecat Android Api Key',
            'refundLink' => 'Your refund link',
            'rewardPoint' => 'Your Reward Point',
        ];

        $ads_Settings = [
            'admobile_publisher_id' => 'Your Admobile Publisher Id',
            'admobile_app_id' => 'Your Admobile App Id',
            'open_ads_id' => 'Your Open Ads Id',
            'rateapp_android_id' => 'Your Rateapp Android Id',
            'rateapp_ios_id' => 'Your Rateapp Ios Id',
            'native_id' => 'Your Native Id',
            'ad_banner_android_id' => 'Your Ad Banner Android Id',
            'ad_banner_ios_id' => 'Your Ad Banner Ios Id',
            'ad_reward_android_id' => 'Your Ad Reward Android Id',
            'ad_reward_ios_id' => 'Your Ad Reward Ios Id',
            'add_interstitial_android_id' => 'Your Add Interstitial Android Id',
            'add_interstitial_ios_id' => 'Your Add Interstitial Ios Id',
        ];

        $email_settings = [
            'mail_mailer' => 'smtp',
            'mail_host' => 'smtp.gmail.com',
            'mail_port' => '587',
            'mail_username' => 'smtp.gmail.com',
            'mail_password' => 'enter your email app password',
            'mail_encryption' => 'TLS',
            'mail_from_address' => 'smtp.gmail.com',
            'mail_from_name' => 'megabot',
        ];

        $update_popup_settings = [
            'app_link' => '',
            'description' => '',
            'update_popup_show' => '',
            'new_app_version_code' => 'MEGABOT',
        ];

        Setting::updateOrCreate([
            'general_settings' => $general_settings,
            'ads_Settings' => $ads_Settings,
            'email_settings' => $email_settings,
            'update_popup_settings' => $update_popup_settings,
        ]);
    }
}
