<?php
/**
 * PHPIMS
 *
 * Copyright (c) 2011 Christer Edvartsen <cogo@starzinger.net>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to
 * deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * * The above copyright notice and this permission notice shall be included in
 *   all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 * IN THE SOFTWARE.
 *
 * @package PHPIMS
 * @subpackage Operations
 * @author Christer Edvartsen <cogo@starzinger.net>
 * @copyright Copyright (c) 2011, Christer Edvartsen
 * @license http://www.opensource.org/licenses/mit-license MIT License
 * @link https://github.com/christeredvartsen/phpims
 */

/**
 * Operation factory
 *
 * @package PHPIMS
 * @subpackage Operations
 * @author Christer Edvartsen <cogo@starzinger.net>
 * @copyright Copyright (c) 2011, Christer Edvartsen
 * @license http://www.opensource.org/licenses/mit-license MIT License
 * @link https://github.com/christeredvartsen/phpims
 */
class PHPIMS_Operation {
    /**
     * Factory method
     *
     * @param string $className The name of the operation class to instantiate
     * @param string $method The HTTP method used
     * @param string $hash Hash that will be passed to the operations constructor
     * @return PHPIMS_Operation_Abstract
     * @throws PHPIMS_Operation_Exception
     */
    static public function factory($className, $method, $hash) {
        switch ($className) {
            case 'PHPIMS_Operation_AddImage':
            case 'PHPIMS_Operation_DeleteImage':
            case 'PHPIMS_Operation_EditMetadata':
            case 'PHPIMS_Operation_GetImage':
            case 'PHPIMS_Operation_GetMetadata':
            case 'PHPIMS_Operation_DeleteMetadata':
                $operation = new $className();

                $operation->setHash($hash);
                $operation->setMethod($method);
                $operation->setImage(new PHPIMS_Image());
                $operation->setResponse(new PHPIMS_Server_Response());

                return $operation;
            default:
                throw new PHPIMS_Operation_Exception('Invalid operation', 500);
        }
    }
}