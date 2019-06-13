<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

include_once(dirname(__FILE__).'/../third_party/functions.php');

class Bids extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $access = false;
        if ($this->client) {
            redirect('cmessages');
        }
    }

    public function view($id = false)
    {
        $this->content_view = 'bids/view';
        $bid = $this->view_data['bid'] = DisputeHasBid::find($id);
        $dispute = $this->view_data['dispute'] = Dispute::find($bid->dispute_id);
        $this->view_data['disputeobject'] = DisputeObject::find($dispute->dispute_object_id);

        $this->view_data['backlink'] = 'disputes/view/' . $id;
    }


}
