<?php
declare(strict_types=1);
namespace Ksfraser\FrontAccounting\CRM\Activity\Tests\Unit;
use PHPUnit\Framework\TestCase;
use Ksfraser\FrontAccounting\CRM\Activity\DTO\ActivityDTO;
class ActivityDtoTest extends TestCase
{
    public function testDtoRoundTripsThroughArray(): void {
        $dto = new ActivityDTO(5, 'Notify on new lead', 'record_created', '{"module":"lead"}', 'send_email', '{"template":"welcome"}', '1');
        $arr = $dto->toArray();
        $this->assertSame(5, $arr['rule_id']);
        $this->assertSame('Notify on new lead', $arr['name']);
        $this->assertSame('record_created', $arr['trigger_type']);
        $this->assertSame('send_email', $arr['action_type']);
        $this->assertSame('1', $arr['is_active']);
        $dto2 = ActivityDTO::fromArray($arr);
        $this->assertSame($dto->rule_id, $dto2->rule_id);
        $this->assertSame($dto->name, $dto2->name);
        $this->assertSame($dto->is_active, $dto2->is_active);
    }
    public function testDisplayLabelUsesNameTriggerActionWhenSet(): void {
        $dto = new ActivityDTO(1, 'Notify on new lead', 'record_created', '', 'send_email');
        $this->assertStringContainsString('Notify on new lead', $dto->getDisplayLabel());
        $this->assertStringContainsString('record_created', $dto->getDisplayLabel());
        $this->assertStringContainsString('send_email', $dto->getDisplayLabel());
    }
    public function testDisplayLabelFallsBackToId(): void {
        $dto = new ActivityDTO(9, '', '', '', '', '', '0');
        $this->assertStringContainsString('Activity Rule #9', $dto->getDisplayLabel());
    }
}
