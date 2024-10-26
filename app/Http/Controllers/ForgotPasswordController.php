<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ForgotPasswordController extends Controller
{
    public function showForm()
    {
        return view('forgot_pass');
    }

    public function sendResetCode(Request $request)
{
    // Validate email
    $validator = Validator::make($request->all(), [
        'email' => 'required|email|exists:users,email',
    ]);

    if ($validator->fails()) {
        return redirect()->route('password.request')
            ->withErrors($validator)
            ->withInput();
    }

    // Fetch the user by email
    $user = DB::table('users')->where('email', $request->email)->first();

    // Generate a reset code
    $resetCode = rand(100000, 999999);

    // Store the reset code in the password_resets table
    DB::table('password_resets')->updateOrInsert(
        ['users_id' => $user->id],
        [
            'reset_code' => $resetCode,
            'expiration' => now()->addMinutes(10),
            'used_reset_token' => 0,
        ]
    );

    // Send the reset code via email using PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Server settings for PHPMailer
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = env('MAIL_USERNAME', 'businabicoluniversity@gmail.com'); // Fetch email from .env file
        $mail->Password   = env('MAIL_PASSWORD', 'your-gmail-password'); // Fetch password from .env file
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('businabicoluniversity@gmail.com', 'BUsina');
        $mail->addAddress($user->email);  // Add recipient email

        // Email content
        $mail->isHTML(true); // Set to true for HTML email
        $mail->Subject = 'Reset Password Code from BUsina';
        $mail->Body = "
        <html>
        <body>
            <p>Hello {$user->fname} {$user->lname},</p> <!-- Using $user to get user details -->
            <p>We have received a request to reset your password. If you did not initiate this request, please disregard this email.</p>
            <p>Your reset code is:</p>
            <h2>{$resetCode}</h2> <!-- Display the reset code -->
            <p>Please use this code to reset your password. The code will expire in 10 minutes.</p>
            <p>Best regards,<br>BUsina Team</p>
        </body>
        </html>
        ";

        // Send the email
        $mail->send();

        // Log success (Optional)
        \Log::info("Reset email sent to {$user->email}");

    } catch (Exception $e) {
        // Log the error
        \Log::error("Failed to send reset code. Mailer Error: {$mail->ErrorInfo}");

        // Return error message if email fails to send
        return redirect()->route('password.request')
                        ->with('error', "Failed to send reset code. Mailer Error: {$mail->ErrorInfo}")
                        ->withInput();
    }

    // Return the view with the reset code after successful email send
    return view('pass_emailed', ['resetCode' => $resetCode])->with('success', 'Reset code sent to your email.');
}

    public function verifyResetCode(Request $request)
    {
        // Validate reset code
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'reset_code' => 'required|numeric',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->route('enter_reset_code')
                ->withErrors($validator)
                ->withInput();
        }

        // Fetch the password reset record
        $resetRecord = DB::table('password_resets')
            ->where('reset_code', $request->reset_code)
            ->where('expiration', '>', now())
            ->where('used_reset_token', 0)
            ->first();

        if (!$resetRecord) {
            return redirect()->route('enter_reset_code')
                ->with('error', 'Invalid or expired reset code.');
        }

        // Reset the user's password
        DB::table('users')
            ->where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        // Mark the reset code as used
        DB::table('password_resets')
            ->where('reset_code', $request->reset_code)
            ->update(['used_reset_token' => 1]);

        return redirect()->route('login')->with('success', 'Password reset successful. You can now log in.');
    }

    public function showResetForm()
    {
        return view('reset_pass');
    }
}
