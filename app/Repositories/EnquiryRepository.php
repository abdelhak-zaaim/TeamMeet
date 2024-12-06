<?php

namespace App\Repositories;

use App\Mail\EnquiryMails;
use App\Models\Enquiry;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class EnquiryRepository
 *
 * @version December 25, 2021, 6:47 am UTC
 */
class EnquiryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'first_name',
        'last_name',
        'email',
    ];

    /**
     * Return searchable fields
     */
    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Enquiry::class;
    }

    public function store($input): bool
    {
        try {
            DB::beginTransaction();

            $input['email'] = setEmailLowerCase($input['email']);
            $enquiry = Enquiry::create($input);
            $input['appName'] = getSettingData()['application_name'];
            $input['name'] = $enquiry->full_name;

            Mail::to($input['email'])->send(new EnquiryMails('emails.enquiry.enquiry', 'Enquiry Sent Successfully',
                $input));

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
