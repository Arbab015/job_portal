<?php

namespace App\Http\Controllers;

use App\Models\BoyApplicant;
use App\Models\Compression;
use App\Models\Hod;
use App\Models\JobSeeker;
use App\Models\Professor;
use App\Models\ViceChancellor;
use Exception;
use FFMpeg\Format\Audio\Mp3;
use Illuminate\Http\Request;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use FFMpeg\Format\Video\X264;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\DataTables;
use Mostafaznv\PdfOptimizer\Laravel\Facade\PdfOptimizer;
use Mostafaznv\PdfOptimizer\Enums\PdfSettings;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg as SupportFFMpeg;
use ZipArchive;

class CompressionController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            return DataTables::of(Compression::orderBy('id', 'desc'))
                ->addColumn('checkbox', function ($user) {
                    return '<input type="checkbox" class="checkbox" data_type="compressed_file" title="Select Record" value="' . $user->id . '">';
                })
                ->addColumn('download', function ($row) {
                    $download_icon = '<a href="' . route('compressed_file.download', $row->id) . '"><i class="fa-solid fa-arrow-down ps-2" role="button" title="Download File">
                        </i>
                        </a>';
                    return $download_icon;
                })
                ->addColumn('actions', function ($file) {
                    $edit =  '<i class="fa-solid fa-pen-to-square text-primary edit-btn"
                         role= "button"
                         title="Edit"
                         data-id="' . $file->id . '">
                        </i>';
                    $delete =  '<form action="' . route('compressed_file.destroy', $file->id) . '" method="POST" style="display:inline;">'
                        . csrf_field()
                        . method_field('DELETE')
                        . '<i class="fa-solid fa-trash-can text-danger" role="button" title="Delete" onclick="confirmDelete(event)">
                                </i>'
                        . '</form>';
                    return $edit . ' ' . $delete;
                })
                ->rawColumns(['checkbox', 'download', 'actions'])
                ->make(true);
        }
        return view('backend.compression.index');
    }

    public function fileUpload(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:mp4,mov,avi,webm,mkv,mpp,wav, flac,aiff,wma,jpeg,jpg,png,gif,svg,xlsx,xls,pdf,doc,docx',
            ]);
            $file = $request->file('file');

            $filename = time() . '_' . $file->getClientOriginalName();
            // Store original file
            $original_path = $file->storeAs('files/original_files', $filename, 'public');
            $size_before_bytes = $file->getSize();
            $size_before = $size_before_bytes <= 1048576 ? round($size_before_bytes / 1024, 2) . ' KB' : round($size_before_bytes / 1048576, 2) . ' MB';
            $compressed_file_path = 'files/compressed/' . $filename;
            $file_extension = $file->getClientOriginalExtension();
            $input_full_path = storage_path("app/public/" . $original_path);
            $output_full_path = storage_path("app/public/" . $compressed_file_path);
            // Compress video
            if (in_array($file_extension, ['mp4', 'mov', 'avi', 'webm', 'mkv'])) {
                $format = new X264;
                $format->setKiloBitrate(600);
                FFMpeg::fromDisk('public')
                    ->open($original_path)
                    ->export()
                    ->toDisk('public')
                    ->inFormat($format)
                    ->save($compressed_file_path);
            } elseif (in_array($file_extension, ['mp3', 'wav', 'flac', 'aiff', 'wma'])) {
                logger($file_extension);
                $format = new Mp3();
                $format->setAudioKiloBitrate(28);
                FFMpeg::fromDisk('public')
                    ->open($original_path)
                    ->export()
                    ->inFormat($format)
                    ->save($compressed_file_path);
            }
            // Compress image
            elseif (in_array($file_extension, ['jpeg', 'jpg', 'gif', 'png', 'svg'])) {
                if ($file_extension === 'png') {
                    FFMpeg::fromDisk('public')
                        ->open($original_path)
                        ->addFilter('-compression_level', '9')
                        ->export()
                        ->toDisk('public')
                        ->save($compressed_file_path);
                } else {
                    FFMpeg::fromDisk('public')
                        ->open($original_path)
                        ->addFilter('-qscale:v', '50')
                        ->export()
                        ->toDisk('public')
                        ->save($compressed_file_path);
                }
            } elseif (in_array($file_extension, ['xlsx', 'xls'])) {
                set_time_limit(300);
                $spreadsheet = IOFactory::load($input_full_path);
                $writer = new Xlsx($spreadsheet);
                $writer->setPreCalculateFormulas(false);
                $writer->save($output_full_path);
            } elseif (in_array($file_extension, ['docx', 'doc'])) {
                $zip_file_name = pathinfo($filename, PATHINFO_FILENAME) . '.zip';
                $zip_full_path = storage_path('app/public/files/compressed/' . $zip_file_name);

                $zip = new ZipArchive;
                if ($zip->open($zip_full_path, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
                    $zip->addFile($input_full_path, $filename);
                    $zip->close();
                }

                $compressed_file_path = 'files/compressed/' . $zip_file_name;
            } elseif ($file_extension == 'pdf') {
                $result = PdfOptimizer::fromDisk('public')
                    ->open($original_path)
                    ->toDisk('public')
                    ->settings(PdfSettings::SCREEN)
                    ->optimize($compressed_file_path);
                if (!$result->status) {
                    throw new Exception('PDF compression failed: ' . $result->message);
                }
            }
            $size_after_bytes = Storage::disk('public',)->size($compressed_file_path);
            $size_after = $size_after_bytes <= 1048576 ? round($size_after_bytes / 1024, 2) . " KB" : round($size_after_bytes / 1048576, 2) . ' MB';
            Compression::create([
                'file' => $compressed_file_path,
                'filetype' => $file_extension,
                'size_before' => $size_before,
                'size_after' => $size_after,
            ]);
            $original_file = 'files/original_files/' . $filename;
            if (Storage::disk('public')->exists($original_file)) {
                Storage::disk('public')->delete($original_file);
            }
            return back()->with('success', 'File uploaded and compressed successfully.');
        } catch (Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function bulkDelete(Request $request)
    {
        try {
            $compressions = Compression::whereIn('id', $request->ids)->get();
            foreach ($compressions as $compression) {
                if (Storage::disk('public')->exists($compression->file)) {
                    Storage::disk('public')->delete($compression->file);
                }
            }
            Compression::whereIn('id', $request->ids)->delete();
            return response()->json(['success' => true]);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }
    public function download(Request $request, $id)
    {
        try {
            $compressed_file = Compression::findOrFail($id);
            $file_path = $compressed_file->file;
            if (Storage::disk('public')->exists($file_path)) {
                return Storage::disk('public')->download($file_path);
            }
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $requested_file = Compression::findOrFail($id);
            $file_name = $requested_file->file;
            $requested_file->delete();
            if (Storage::disk('public')->exists($file_name)) {
                Storage::disk('public')->delete($file_name);
            }
            return redirect()->back()->with('success', 'Your file deleted Successfully. ');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }
    public function update(Request $request, $id)
    {
        // try {
        //     $request->validate([
        //         'file' => 'required|mimes:mp4,mov,avi,jpeg,jpg,png,gif,xlsx,pdf,doc,docx',
        //     ]);
        //     $requested_file = Compression::findOrFail($id);
        //     $file_name = $requested_file->file;
        //     // delete from disk 
        //     if (Storage::disk('public')->exists($file_name)) {
        //         Storage::disk('public')->delete($file_name);
        //     }
        //     $file = $request->file('file');
        //     $filename = time() . '_' . $file->getClientOriginalName();
        //     // Store original file
        //     $original_path = $file->storeAs('files/original_files', $filename, 'public');
        //     $size_before_bytes = $file->getSize();
        //     $size_before = $size_before_bytes <= 1048576 ? round($size_before_bytes / 1024, 2) . ' KB' : round($size_before_bytes / 1048576, 2) . ' MB';
        //     $compressed_file_path = 'files/compressed/' . $filename;
        //     $file_extension = $file->getClientMimeType();
        //     $input_full_path = storage_path("app/public/" . $original_path);
        //     $output_full_path = storage_path("app/public/" . $compressed_file_path);
        //     // Compress video
        //     if (str_contains($file_extension, 'video')) {
        //         $ffmpeg = FFMpeg::create([
        //             'ffmpeg.binaries'  => env('FFMPEG_BINARIES', 'C:/ffmpeg/bin/ffmpeg.exe'),
        //             'ffprobe.binaries' => env('FFPROBE_BINARIES', 'C:/ffmpeg/bin/ffprobe.exe'),
        //         ]);
        //         $size_before = round($size_before_bytes / 1048576, 2) . ' MB';
        //         $video = $ffmpeg->open($input_full_path);
        //         $format = new X264;
        //         $format->setKiloBitrate(600);
        //         $video->save($format, $output_full_path);
        //     }
        //     // Compress image
        //     elseif (str_contains($file_extension, 'image')) {

        //         $extension = $file->getClientOriginalExtension();
        //         if ($extension === 'png') {
        //             FFMpeg::fromDisk('public')
        //                 ->open($original_path)
        //                 ->addFilter('-compression_level', '4')
        //                 ->addFilter('-pix_fmt', 'rgba')
        //                 ->export()
        //                 ->toDisk('public')
        //                 ->save($compressed_file_path);
        //         } else {
        //             // JPG / JPEG compression
        //             FFMpeg::fromDisk('public')
        //                 ->open($original_path)
        //                 ->addFilter('-qscale:v', '7')
        //                 ->export()
        //                 ->toDisk('public')
        //                 ->save($compressed_file_path);
        //         }
        //     } elseif (str_contains($file_extension, 'spreadsheet')) {
        //         set_time_limit(300);
        //         $spreadsheet = IOFactory::load($input_full_path);
        //         $writer = new Xlsx($spreadsheet);
        //         $writer->setPreCalculateFormulas(false);
        //         $writer->save($output_full_path);
        //     } elseif (in_array($file_extension, ['wordprocessingml', 'application/pdf', 'application/word'])) {
        //         // Create zip path
        //         $zip_file_name = pathinfo($filename, PATHINFO_FILENAME) . '.zip';
        //         $zip_full_path = storage_path('app/public/files/compressed/' . $zip_file_name);
        //         // Create zip object
        //         $zip = new ZipArchive;
        //         if ($zip->open($zip_full_path, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
        //             $zip->addFile($input_full_path, $filename);
        //             $zip->close();
        //         }
        //         $compressed_file_path = 'files/compressed/' . $zip_file_name;
        //     }
        //     $size_after_bytes = Storage::disk('public',)->size($compressed_file_path);
        //     $size_after = $size_after_bytes <= 1048576 ? round($size_after_bytes / 1024, 2) . " KB" : round($size_after_bytes / 1048576, 2) . ' MB';
        //     $requested_file->update([
        //         'file' => $compressed_file_path,
        //         'filetype' => $file_extension,
        //         'size_before' => $size_before,
        //         'size_after' => $size_after,
        //     ]);
        //     $original_file = 'files/original_files/' . $filename;
        //     if (Storage::disk('public')->exists($original_file)) {
        //         Storage::disk('public')->delete($original_file);
        //     }
        //     return back()->with('success', 'File updated and compressed successfully.');
        // } catch (Exception $e) {
        //     return back()->withInput()->with('error', $e->getMessage());
        // }
    }
}
