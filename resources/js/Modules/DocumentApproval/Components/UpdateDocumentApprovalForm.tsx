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
import useModalStore from "@/Modules/Common/Hooks/use-modal-store";
import { useUpdateDocumentApproval } from "../Hooks/use-update-document-approval";
import { DocumentResourceData } from "@/Modules/Document/Types/DocumentResourceData";

interface IFormProps {
    document?: DocumentResourceData;
}

const UpdateDocumentApprovalForm: React.FC<IFormProps> = ({ document }) => {
    const { modals, closeModal } = useModalStore();
    const isOpen = modals["updateDocumentApproval"];

    const {
        data,
        setData,
        handleUpdateDocumentApproval,
        processing,
        fetchedUsers,
        setDocumentApprovalType,
        errors,
    } = useUpdateDocumentApproval({
        documentApprovalId: document?.document_approval_id,
        isOpen,
    });

    return (
        <Modal
            opened={modals["updateDocumentApproval"]}
            onClose={() => closeModal("updateDocumentApproval")}
            title={
                <Text fw="bold" size="lg">
                    Update Document Approval Process
                </Text>
            }
            size={550}
        >
            <form onSubmit={handleUpdateDocumentApproval}>
                <Stack gap={16}>
                    <Text size="sm" c="dimmed">
                        Routinely directs any uploaded file in this folder through a predefined
                        document approval process
                    </Text>

                    <Radio.Group
                        name="status"
                        value={data.type}
                        onChange={(value: string) => {
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

                    {fetchedUsers.map(user => (
                        <Paper withBorder radius="md" py={16} px={10} key={user.id}>
                            <Group>
                                <Avatar />
                                <Stack gap={8}>
                                    <Text size="sm">{user.name}</Text>
                                    <Text size="sm">{user.email}</Text>
                                </Stack>
                            </Group>
                        </Paper>
                    ))}
                </Stack>

                <Flex align="center" justify="end" mt={16}>
                    <Button variant="light" onClick={() => closeModal("updateDocumentApproval")}>
                        Cancel
                    </Button>

                    <Button ml={12} type="submit" loading={processing}>
                        Update
                    </Button>
                </Flex>
            </form>
        </Modal>
    );
};

export default UpdateDocumentApprovalForm;