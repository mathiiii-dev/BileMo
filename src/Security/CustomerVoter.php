<?php

namespace App\Security;

use App\Entity\Customer;
use App\Entity\User;
use Exception;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class CustomerVoter extends Voter
{
    const OWNER = 'owner';

    protected function supports(string $attribute, $subject): bool
    {
        if (!in_array($attribute, [self::OWNER])) {
            return false;
        }

        if (!$subject instanceof Customer) {
            return false;
        }

        return true;
    }

    /**
     * @throws Exception
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        return $this->canDelete($subject, $user);
    }

    /**
     * @throws Exception
     */
    private function canDelete(Customer $customer, User $user): bool
    {
        if ($customer->getClient()->getId() !== $user->getId()) {
            throw new AccessDeniedHttpException("You can't delete this customer");
        }

        return true;
    }
}
