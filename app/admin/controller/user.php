<?php

class user extends Controller {

    function auto() {
        $page = new Page('user', '*', 'userid');
        $data = array(
            'newpage' => $page->run(),
            'results' => $page->sql()
        );
        View::load('userlists', $data);
    }

    function add() {
        $results = array(
            'username' => '',
            'nickname' => '',
            'email' => '',
        );
        View::load('useredit', array(
            'results' => $results,
        ));
    }

    function me() {
        if (Z::$username != '') {
            $this->update(Z::$username);
        } else {
            $this->add();
        }
    }

    function edit() {
        $name = Get::string(0);
        $this->update($name);
    }

    private function update($name) {
        $results = DB::table('user')->where('username=?', array($name))
            ->find('username,nickname,email,roleid');
        View::load('useredit', array(
            'results' => $results,
            'noname' => true,
        ));
    }

    function save() {
        $username = Input::text('username');
        if ($username !== '') {
            $data = array(
                'nickname' => Input::text('nickname'),
                'email' => Input::text('email'),
            );
            DB::table('user')->where('username=?', array($username))->update($data);
        } else {
            $username = Input::text('newusername');
            $results = DB::table('user')->where('username=?', array($username))->findOne('username');
            if (empty($results)) {
                $data = array(
                    'username' => Input::text('newusername'),
                    'nickname' => Input::text('nickname'),
                    'email' => Input::text('email'),
                );
                $done = DB::table('user')->insert($data);
                if ($done) {
                    Html::alert('ok');
                    Html::jump(URL::controller());
                } else {
                    Html::alert('error');
                    Html::jumpBack();
                }
            } else {
                Html::alert('the username has exists');
                Html::jumpBack();
            }
        }
    }

    function delete() {
        $name = Get::string(0);
        $done=DB::table('user')->where('username=?',array($name))->delete();
        if($done){
            jump(URL::controller());
        }else{
            Html::alert('error');
            Html::jumpBack();
        }
    }

}
