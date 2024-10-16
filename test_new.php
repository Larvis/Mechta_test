<?php

namespace App\Http\Controllers\vBulletin\Search;

use App\Models\SystemUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SearchController extends Controller
{
    /**
     *
     * */

    /**
     *  $_REQUEST['do'] == 'showresults'
    */
    public function doResultsID(SResultsRequest $request): JsonResponse
    {
        $data = $request->validated();


        $response = VBSearchResult::where('forumid', '!=', EnumForums::FIVE)->where('searchid', $data->searchid)->paginate();

        return response()->json($response, options: JSON_UNESCAPED_UNICODE);
    }

    /**
     *  $_REQUEST['do'] == 'process' || q
     */
    public function doText(STextRequest $request): JsonResponse {

        // v1
        $data = $request->validated();

        //v2 Функция валидации входящих данных из формы, но лучше делать через Request
//        $validator = Validator::make($request->all(), ['text' => ['required', 'string']]);

//        if ($validator->fails()) {
//            return $this->arrayError($validator->errors()); // Операция не выполнена
//        }

        $unit_text = htmlspecialchars(trim($data->query), ENT_QUOTES, 'UTF-8');

        /* Custom enum, wherelike, paginate */
        $response = VBPost::where('forumid', '!=', EnumForums::FIVE)->whereLike('text', $unit_text)->paginate();
        /* Либо можно в модели записать форумы по умолчанию -
            protected $attributes = [
                'forumid' => 1,
            ];
        */


        Log::info($_REQUEST['query']); // Либо через таблицу с логами LogsQueryModel::create(['query' => $_REQUEST['query']]) */
        /* else {
              return $this->errorResponse(['message' => __('Данные не найдены')]); // ApiController custom messages method
        } */

        return response()->json($response, options: JSON_UNESCAPED_UNICODE);
    }

}
