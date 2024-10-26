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
import { useCreateDocumentApproval } from "../Hooks/use-create-document-approval";
import useModalStore from "@/Modules/Common/Hooks/use-modal-store";
import { DocumentResourceData } from "@/Modules/Document/Types/DocumentResourceData";

interface IFormProps {
    document?: DocumentResourceData;
}

const CreateDocumentApprovalForm: React.FC<IFormProps> = ({ document }) => {
    const {
        data,
        setData,
        createApprovalSubmit,
        processing,
        errors,
        users,
        setDocumentApprovalType
    } = useCreateDocumentApproval({
        documentId: document?.item_id,
    });

    const { modals, closeModal } = useModalStore();

    return (
        <Modal
            opened={modals["createDocumentApproval"]}
            onClose={() => closeModal("createDocumentApproval")}
            title={
                <Text fw="bold" size="lg">
                    Create Document Approval Process
                </Text>
            }
            size={550}
        >
            <form onSubmit={createApprovalSubmit}>
                <Stack gap={16}>
                    <Text size="sm" c="dimmed">
                        Routinely directs any uploaded file in this folder through a predefined
                        document approval process
                    </Text>

                    <Radio.Group
                        name="status"
                        value={data.type}
                        onChange={(value) => {
                            setData("type", value);
                            setDocumentApprovalType(value);
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
                        Users in this document approval
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
                    <Button variant="light" onClick={() => closeModal("createDocumentApproval")}>
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

export default CreateDocumentApprovalForm;