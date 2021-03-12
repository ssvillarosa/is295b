<?php echo 'Welcome '.
        $this->session->userdata(SESS_APPLICANT_FIRST_NAME).' '.
        $this->session->userdata(SESS_APPLICANT_LAST_NAME); ?>