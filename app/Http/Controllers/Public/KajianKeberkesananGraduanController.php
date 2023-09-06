<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\KajianKeberkesananGraduan;
use App\Models\JawapanKajianKeberkesananGraduan;
use Hashids\Hashids;
use Illuminate\Http\Request;

class KajianKeberkesananGraduanController extends Controller
{
    public function index($id)
    {
        $hashids = new Hashids('', 20);
        $form = KajianKeberkesananGraduan::find($hashids->decodeHex($id));
        $form_value = null;
        if ($form) {
            $array = $form->getFormArray();

            return view('pages.public.kaji_selidik_alumni', compact('form', 'form_value', 'array'));
        } else {
            return redirect()->route('public.index');
        }
    }

    public function fill_store(Request $request, $id)
    {
        $form = KajianKeberkesananGraduan::find($id);

        if ($form) {
            $client_emails = [];
            $array = $form->getFormArray();
            foreach ($array as &$rows) {

                foreach ($rows as &$row) {
                    if ($row->type == 'checkbox-group') {
                        foreach ($row->values as &$value) {
                            if (is_array($request->{$row->name}) && in_array($value->value, $request->{$row->name})) {
                                $value->selected = 1;
                            } else {
                                if (isset($value->selected)) {
                                    unset($value->selected);
                                }
                            }
                        }
                    } elseif ($row->type == 'radio-group') {
                        foreach ($row->values as &$value) {
                            if ($value->value == $request->{$row->name}) {
                                $value->selected = 1;
                            } else {
                                if (isset($value->selected)) {
                                    unset($value->selected);
                                }
                            }
                        }
                    } elseif ($row->type == 'select') {
                        if (isset($row->multiple) & !empty($row->multiple)) {
                            foreach ($row->values as &$value) {
                                if (is_array($request->{$row->name}) && in_array($value->value, $request->{$row->name})) {
                                    $value->selected = 1;
                                } else {
                                    if (isset($value->selected)) {
                                        unset($value->selected);
                                    }
                                }
                            }
                        } else {
                            foreach ($row->values as &$value) {
                                if ($value->value == $request->{$row->name}) {
                                    $value->selected = 1;
                                } else {
                                    if (isset($value->selected)) {
                                        unset($value->selected);
                                    }
                                }
                            }
                        }
                    } elseif ($row->type == 'date') {
                        $row->value = $request->{$row->name};
                    } elseif ($row->type == 'number') {
                        $row->value = $request->{$row->name};
                    } elseif ($row->type == 'textarea') {
                        $row->value = $request->{$row->name};
                    } elseif ($row->type == 'text') {
                        $client_email = '';
                        if ($row->subtype == 'email') {
                            if (isset($row->is_client_email) && $row->is_client_email) {

                                $client_emails[] = $request->{$row->name};
                            }
                        }
                        $row->value = $request->{$row->name};
                    }
                }
            }
            $data = [];
            $data['borang_kaji_selidik_id'] = $form->id;
            $data['json'] = json_encode($array);
            $form_value = JawapanKajianKeberkesananGraduan::create($data);

            return response()->json(
                [
                    'is_success' => true,
                    'message' => __('berjaya_1'),
                    'redirect' => route('public.index'),
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'is_success' => false,
                    'message' => __('Form not found'),
                ],
                200
            );
        }
    }
}
