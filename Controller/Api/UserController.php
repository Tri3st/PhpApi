<?php

class UserController extends BaseController
{
    /**
     * "/user/list" Endpoint - Get list of users
     */
    public function listUserAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        if (strtoupper($requestMethod) == 'GET') {
            try {
                $userModel = new UserModel();
                $intLimit = 10;
                if (isset($arrQueryStringParams['limit']) && $arrQueryStringParams['limit']) {
                    $intLimit = $arrQueryStringParams['limit'];
                }
                $arrUsers = $userModel->getUsers($intLimit);
                $responseData = json_encode($arrUsers);
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

    /**
     * Checks if the user provided in the Basic authorization is found in the database and saves the user role.
     *
     * @return boolean
     */
    public function checkUserAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        if (strtoupper($requestMethod) == 'POST') {
            try {
                if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']))
                {
                    $username = $_SERVER['PHP_AUTH_USER'];
                    $password = $_SERVER['PHP_AUTH_PW'];

                    echo("Username " . $username . " with password " . $password . " received.\n");
                    $userModel = new UserModel();
                    $foundUser = $userModel->getUserPassword($username);
                    $passwordFromDb = trim($foundUser[0]["password"]);
                    // $foundUser = array(1) {
                    //  [0]=>
                    //  array(1) {
                    //    ["password"]=>
                    //    string(33) "098f6bcd4621d373cade4e832627b4f6"
                    //  }
                    //}

                    if(strcmp(md5($password), $passwordFromDb) == 0)
                    {
                        echo("User credentials valid!");
                        $userRole = $userModel->getUserRole($username)[0];
                        if ($userRole < 3) {
                            echo("Userrole is sufficient.");
                            return true;
                        } else {
                            $strErrorDesc = 'User authorization invalid!';
                            $strErrorHeader = 'HTTP/1.1 404 Invalid Autorization';
                        }

                    }
                    else {
                        $strErrorDesc = 'User credentials invalid!';
                        $strErrorHeader = 'HTTP/1.1 404 Invalid Credentials';
                    }
                }
                else
                {
                    $strErrorDesc = 'Something went wrong! Please contact support.';
                    $strErrorHeader = 'HTTP/1.1 500 Credentials are needed';
                }

            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        return false;
    }

}
