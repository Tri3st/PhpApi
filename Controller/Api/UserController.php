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
     * @return void
     */
    protected function checkUserAction()
    {
        if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']))
        {
            header('WWW-Authenticate: Basic realm="api.vandiest.xyz"');
            header('HTTP/1.0 401 Unautherized');
            echo 'Authentication required';
            exit;
        }

        // Authenticate user credentials
        $username = $_SERVER['PHP_AUTH_USER'];
        $password = $_SERVER['PHP_AUTH_PW'];

        echo($username . $password);

        // Query the database for the user with th given credentials
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmtm->fetch(PDO::FETCH_ASSOC);

        if(!$user || !password_verify($password, $user['password']))
        {
            header('HTTP/1.0 401 Unauthorized');
            echo 'Invalid credentials';
            exit;
        }

        return $user;
    }
}
