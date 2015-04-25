<?php

namespace Sf\PrelaunchrBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="registered_user")
 * @UniqueEntity("email")
 */
class RegisteredUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", length=64, unique=true)
     * @Assert\Email()
     */
    protected $email;
    
    /**
     * @ORM\Column(type="string", length=32, unique=true)
     */
    protected $referral_code;
    
    /**
     * @ORM\OneToMany(targetEntity="RegisteredUser", mappedBy="referrer")
     **/
    private $referrals;
    
    /**
     * @ORM\ManyToOne(targetEntity="RegisteredUser", inversedBy="referrals")
     * @ORM\JoinColumn(name="referer_id", referencedColumnName="id")
     **/
    protected $referrer;
    
    
    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $created_at;
        
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->referrals = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return RegisteredUser
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * Set referral_code
     *
     * @param string $referralCode
     * @return RegisteredUser
     */
    public function setReferralCode($referralCode)
    {
        $this->referral_code = $referralCode;

        return $this;
    }

    /**
     * Get referral_code
     *
     * @return string 
     */
    public function getReferralCode()
    {
        return $this->referral_code;
    }
    
    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return RegisteredUser
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Add referrals
     *
     * @param \Sf\PrelaunchrBundle\Entity\RegisteredUser $referrals
     * @return RegisteredUser
     */
    public function addReferral(\Sf\PrelaunchrBundle\Entity\RegisteredUser $referrals)
    {
        $this->referrals[] = $referrals;

        return $this;
    }

    /**
     * Remove referrals
     *
     * @param \Sf\PrelaunchrBundle\Entity\RegisteredUser $referrals
     */
    public function removeReferral(\Sf\PrelaunchrBundle\Entity\RegisteredUser $referrals)
    {
        $this->referrals->removeElement($referrals);
    }

    /**
     * Get referrals
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReferrals()
    {
        return $this->referrals;
    }

    /**
     * Set referrer
     *
     * @param \Sf\PrelaunchrBundle\Entity\RegisteredUser $referrer
     * @return RegisteredUser
     */
    public function setReferrer(\Sf\PrelaunchrBundle\Entity\RegisteredUser $referrer = null)
    {
        $this->referrer = $referrer;

        return $this;
    }

    /**
     * Get referrer
     *
     * @return \Sf\PrelaunchrBundle\Entity\RegisteredUser 
     */
    public function getReferrer()
    {
        return $this->referrer;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function timestamp() {
        
        if (is_null($this->getCreatedAt())) {
            $this->setCreatedAt(new \DateTime());
            $this->setReferralCode(md5($this->getEmail()));
        }
                
        return $this;
    }
    
    public function getReferralsCount(){
        return $this->getReferrals()->count();
    }
    
    public function getReferralSteps(){
        return array(
            array(
                'count' => 5,
                "html" => "Shave<br>Cream",
                "class" => "two",
                "image" =>  "bundles/sfprelaunchr/images/refer/cream-tooltip@2x.png"
            ),
            array(
                'count' => 10,
                "html" => "Truman Handle<br>w/ Blade",
                "class" => "three",
                "image" => "bundles/sfprelaunchr/images/refer/truman@2x.png"
            ),
            array(
                'count' => 25,
                "html" => "Winston<br>Shave Set",
                "class" => "four",
                "image" => "bundles/sfprelaunchr/images/refer/winston@2x.png"
            ),
            array(
                'count' => 50,
                "html" => "One Year<br>Free Blades",
                "class" => "five",
                "image" => "bundles/sfprelaunchr/images/refer/blade-explain@2x.png"
            )
        );
    }
}
