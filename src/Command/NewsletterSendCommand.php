<?php

namespace VladFilimon\MultiNewsletterPlugin\Command;

use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Mailer\Sender\SenderInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use VladFilimon\MultiNewsletterPlugin\Repository\NewsletterRepository;

#[AsCommand(
    name: 'newsletter:send',
    description: 'Add a short description for your command',
)]
class NewsletterSendCommand extends Command
{
    protected $newsletterRepo;
    protected $mailer;
    protected $channel;

    public function __construct(string $name = null, NewsletterRepository $newsletterRepository, SenderInterface $mailer, ChannelContextInterface $channel)
    {
        parent::__construct($name);
        $this->newsletterRepo = $newsletterRepository;
        $this->mailer = $mailer;
        $this->channel = $channel->getChannel();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('newsletter_id', InputArgument::REQUIRED, 'Newsletter id (to obtain list of subscribers)')
            ->addArgument('template_code', InputArgument::REQUIRED, 'The Sylius newsletter template code (contains both body and subject)')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $newsletterId = $input->getArgument('newsletter_id');
        $templateCode = $input->getArgument('template_code');

        $nrEmailsSent = 0;

        $newsletter = $this->newsletterRepo->find($newsletterId);
        if (!$newsletter) {
            $io->error("Newsletter with id {$newsletterId} does not exist");

            return Command::FAILURE;
        }
        if (!$newsletter->getEnabled()) {
            $io->error('Given newsletter is disabled');

            return Command::FAILURE;
        }

        $io->info(sprintf('Newsletter id: %s contains %d subscribers', $newsletterId, $newsletter->getShopUsers()->count()));

        foreach ($newsletter->getShopUsers() as $shopUser) {
            $this->mailer->send(
                $templateCode,
                [$shopUser->getCustomer()->getEmail()],
                ['customer' => $shopUser->getCustomer(), 'newsletter' => $newsletter, 'channel' => $this->channel, 'localeCode' => 'en_EN']
            )
            ;
            ++$nrEmailsSent;
        }

        if ($nrEmailsSent > 0) {
            $io->success("Succesfully send to {$nrEmailsSent} email addresses");
        } else {
            $io->warning('No emails have been sent.');
        }

        return Command::SUCCESS;
    }
}
