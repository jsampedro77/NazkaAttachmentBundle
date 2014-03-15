<?php

namespace Nazka\AttachmentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nazka\AttachmentBundle\Form\AttachmentCollectionType;

/**
 * Description of AttachmentController
 *
 * @author javier
 */
class AttachmentController extends Controller
{

    /**
     * 
     * @param type $id
     * @return type
     */
    public function getAction($id)
    {
        $manager = $this->get('nazka_attachment.attachment.manager');
        $attachment = $manager->find($id);

        if ($manager->isImage($attachment)) {
            $template = 'NazkaAttachmentBundle:Attachment:image.html.twig';
        } elseif ($manager->isVideo($attachment)) {
            $template = 'NazkaAttachmentBundle:Attachment:video.html.twig';
        } else {
            return $this->getContentAction($id);
        }

        return $this->render($template, array(
                    'attachment' => $attachment
        ));
    }

    /**
     * 
     * @param type $attachable_id
     * @return type
     */
    public function listAction($attachable_id, $partial = false, $accessHelp = null)
    {
        $manager = $this->get('nazka_attachment.attachable.manager');

        $attachable = $manager->find($attachable_id);
        $attachments = $manager->getAttachments($attachable);
        $newForm = $this->createAttachmentsForm($attachable, $accessHelp);

        if ($partial) {
            $template = 'NazkaAttachmentBundle:Attachment:_list.html.twig';
        } else {
            $template = 'NazkaAttachmentBundle:Attachment:list.html.twig';
        }

        return $this->render($template, array(
                    'attachments' => $attachments,
                    'newForm' => $newForm->createView()
        ));
    }

    /**
     * 
     * @param type $id
     * @return type
     */
    public function getContentAction($id)
    {
        $manager = $this->get('nazka_attachment.attachable.manager');

        // Download attachment content.
        // Manager will check for security and throw AccessDeniedException if use has no privileges.
        return $manager->downloadAttachmentById($id);
    }

    public function newAction(Request $request)
    {
        $form = $this->createAttachmentsForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $manager = $this->get('nazka_attachment.attachable.manager');
            $attachable = $manager->addAttachments($form->getData()['attachable'], $form->getData()['attachments']);
        } else {
            return new Response($form->getErrorsAsString(5));
        }

        return $this->listAction($attachable->getId(), true); //render partial list
    }

    public function createAttachmentsForm($attachable = null, $accessHelp = null)
    {
        $data = array('attachable' => $attachable);

        return $this->createForm(new AttachmentCollectionType(), $data, array(
            'em' => $this->getDoctrine()->getManager(),
            'accessHelp' => $accessHelp
        ));
    }
}
