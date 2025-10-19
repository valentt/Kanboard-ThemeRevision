<?php

namespace Kanboard\Plugin\ThemeRevisionPlus\Controller;

use Kanboard\Controller\BaseController;

/**
 * ThemeRevisionPlus - Mobile Settings Controller
 * Handles toggling mobile beta features on/off per user
 */
class MobileSettingsController extends BaseController
{
    /**
     * Toggle mobile beta feature for current user
     */
    public function toggle()
    {
        // Check if user is logged in
        if (!$this->userSession->isLogged()) {
            $this->response->redirect($this->helper->url->to('AuthController', 'login'));
            return;
        }

        // Get the enable parameter from request
        $enabled = $this->request->getStringParam('enable', '0') === '1' ? '1' : '0';

        // Save to user metadata
        $this->userMetadataModel->save(
            $this->userSession->getId(),
            ['mobile_beta' => $enabled]
        );

        // Flash message
        if ($enabled === '1') {
            $this->flash->success(t('Mobile features enabled'));
        } else {
            $this->flash->success(t('Mobile features disabled'));
        }

        // Redirect back to board or settings
        $redirect = $this->request->getStringParam('redirect', '');

        if ($redirect === 'settings') {
            $this->response->redirect($this->helper->url->to('UserViewController', 'show', array('user_id' => $this->userSession->getId())));
        } else {
            // Try to redirect back to the board view
            $controller = $this->request->getStringParam('controller', 'BoardViewController');
            $action = $this->request->getStringParam('action', 'show');
            $projectId = $this->request->getIntegerParam('project_id', 0);

            if ($projectId > 0) {
                $this->response->redirect($this->helper->url->to($controller, $action, array('project_id' => $projectId)));
            } else {
                $this->response->redirect($this->helper->url->to('DashboardController', 'show'));
            }
        }
    }

    /**
     * Check if mobile features are enabled for current user
     */
    public function isEnabled()
    {
        if (!$this->userSession->isLogged()) {
            return true; // Default enabled for guests
        }

        return $this->userMetadataModel->get(
            $this->userSession->getId(),
            'mobile_beta',
            '1'
        ) === '1';
    }
}
