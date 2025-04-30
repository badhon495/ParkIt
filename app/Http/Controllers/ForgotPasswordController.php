namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    public function showForm()
    {
        return view('forgot_password');
    }

    public function sendNewPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $user = DB::table('usr_user')->where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'No user found with this email'])->withInput();
        }
        // Generate new password
        $newPassword = substr(str_shuffle('abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789'), 0, 10);
        // Update password in DB (hashed)
        DB::table('usr_user')->where('user_id', $user->user_id)->update([
            'password' => Hash::make($newPassword),
        ]);
        // Send email
        Mail::raw('Your new password for ParkIt is: ' . $newPassword, function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Your New ParkIt Password');
        });
        return back()->with('success', 'A new password has been sent to your email.');
    }
}
