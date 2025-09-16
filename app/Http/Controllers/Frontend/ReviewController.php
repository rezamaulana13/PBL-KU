<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Review;
use Carbon\Carbon;


class ReviewController extends Controller
{
    /**
     * Simpan review baru (dengan media opsional)
     */
    public function StoreReview(Request $request)
    {
        $client = $request->client_id;

        // Validasi input
        $request->validate([
            'comment' => 'required|string',
            'rating'  => 'nullable|numeric|min:1|max:5',
            'media'   => 'nullable|file|mimes:jpg,jpeg,png,webp,mp4,mov,avi|max:5120',
        ]);

        // Default media null
        $mediaPath = null;

        // Jika ada file media (foto/video)
        if ($request->hasFile('media')) {
            $mediaPath = $request->file('media')->store('reviews', 'public');
            // disimpan di storage/app/public/reviews
        }

        // Simpan ke database
        Review::create([
            'client_id'  => $client,
            'user_id'    => Auth::id(),
            'comment'    => $request->comment,
            'rating'     => $request->rating,
            'media'      => $mediaPath,
            'status'     => 0, // default pending
            'created_at' => Carbon::now(),
        ]);

        // Notifikasi
        $notification = [
            'message'    => 'Review berhasil dikirim & akan direview admin.',
            'alert-type' => 'success'
        ];

        // Redirect kembali ke halaman produk + tab review
        $previousUrl = $request->headers->get('referer');
        $redirectUrl = $previousUrl
            ? $previousUrl . '#pills-reviews'
            : route('res.details', ['id' => $client]) . '#pills-reviews';

        return redirect()->to($redirectUrl)->with($notification);
    }

    /**
     * Review Pending (Admin)
     */
    public function AdminPendingReview()
    {
        $pendingReview = Review::where('status', 0)->orderBy('id', 'desc')->get();
        return view('admin.backend.review.view_pending_review', compact('pendingReview'));
    }

    /**
     * Review Approved (Admin)
     */
    public function AdminApproveReview()
    {
        $approveReview = Review::where('status', 1)->orderBy('id', 'desc')->get();
        return view('admin.backend.review.view_approve_review', compact('approveReview'));
    }

    /**
     * Ganti status review (ajax admin)
     */
    public function ReviewChangeStatus(Request $request)
    {
        $review = Review::findOrFail($request->review_id);
        $review->status = $request->status;
        $review->save();

        return response()->json(['success' => 'Status berhasil diubah.']);
    }

    /**
     * Tampilkan semua review milik Client
     */
    public function ClientAllReviews()
    {
        $id = Auth::guard('client')->id();
        $allreviews = Review::where('status', 1)
            ->where('client_id', $id)
            ->orderBy('id', 'desc')
            ->get();

        return view('client.backend.review.view_all_review', compact('allreviews'));
    }
}
