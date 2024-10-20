import {
    Avatar,
    Button,
    Flex,
    Group,
    Modal,
    Paper,
    Radio,
    Stack,
    Text,
    Textarea,
} from "@mantine/core";
import { ItemParentResourceData } from "@/Modules/Item/Types/ItemParentResourceData";
import { useCreateWorkflow } from "../Hooks/use-create-workflow";
import useModalStore from "@/Modules/Common/Hooks/use-modal-store";

interface IFormProps {
    itemParent?: ItemParentResourceData;
}

const CreateWorkflowForm: React.FC<IFormProps> = ({ itemParent }) => {
    const {
        data,
        setData,
        createApprovalSubmit,
        processing,
        errors,
        users,
        setWorkflowType
    } = useCreateWorkflow({
        itemParentId: itemParent?.item_id,
    });

    const { modals, closeModal } = useModalStore();

    return (
        <Modal
            opened={modals["workflow"]}
            onClose={() => closeModal("workflow")}
            title={
                <Text fw="bold" size="lg">
                    Create Workflow Process
                </Text>
            }
            size={550}
        >
            <form onSubmit={createApprovalSubmit}>
                <Stack gap={16}>
                    <Text size="sm" c="dimmed">
                        Routinely directs any uploaded file in this folder through a predefined
                        approval workflow
                    </Text>

                    <Radio.Group
                        name="status"
                        value={data.type}
                        onChange={(value) => {
                            setData("type", value);
                            setWorkflowType(value);
                        }}
                    >
                        <Group mt="xs">
                            <Radio value="reviewal" label="Review" />
                            <Radio value="approval" label="Approval" />
                        </Group>
                    </Radio.Group>

                    <Textarea
                        label="Resolution"
                        placeholder="Your resolution for this approval"
                        value={data.resolution ?? ""}
                        onChange={(e) => setData("resolution", e.target.value)}
                        error={errors.resolution}
                        autosize
                        minRows={2}
                        maxRows={4}
                    />

                    <Text size="sm" fw={500} mb={-8}>
                        User in this workflow
                    </Text>

                    {users.map(user => (
                        <Paper withBorder radius="md" py={16} px={10} key={user.id}>
                            <Group>
                                <Avatar />
                                <Stack gap={8}>
                                    <Text size="sm">{user.name}</Text>
                                </Stack>
                            </Group>
                        </Paper>
                    ))}
                </Stack>

                <Flex align="center" justify="end" mt={16}>
                    <Button variant="light" onClick={() => closeModal("workflow")}>
                        Cancel
                    </Button>

                    <Button ml={12} type="submit" loading={processing}>
                        Create
                    </Button>
                </Flex>
            </form>
        </Modal>
    );
};

export default CreateWorkflowForm;