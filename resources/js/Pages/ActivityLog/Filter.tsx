import { PageProps } from "@/types";
import { useForm, usePage } from "@inertiajs/react";
import {
    Button,
    Flex,
    Group,
    Modal,
    Radio,
    Stack,
    Switch,
    Text,
    Textarea,
} from "@mantine/core";
import { useDisclosure } from "@mantine/hooks";
import { notifications } from "@mantine/notifications";
import { IconFilter } from "@tabler/icons-react";
import { FormEventHandler } from "react";

interface IFormProps {
    isOpened: boolean;
    close: () => void;
}

interface FormData {
    name: string;
    parent_id?: number;
}

const ApprovalForm: React.FC<IFormProps> = ({ isOpened, close }) => {
    const { data, post, processing, reset } = useForm<FormData>({
        name: "",
        parent_id: 0,
    });

    const parent_id = usePage<PageProps>().props.folder?.id;

    const createFolderSubmit: FormEventHandler = (e) => {
        e.preventDefault();

        data.parent_id = parent_id;

        post(route("folder.create"), {
            preserveScroll: true,
            onSuccess: () => {
                close();
                notifications.show({
                    message: "Approval process created",
                    color: "green",
                });
            },
            onError: () => {
                close();
                notifications.show({
                    message: "Something went wrong",
                    color: "red",
                });
            },
            onFinish: () => reset(),
        });
    };

    return (
        <Modal
            opened={isOpened}
            onClose={close}
            title={
                <Text fw="bold" size="lg">
                    Filter Activity Log
                </Text>
            }
            size={550}
        >
            <form onSubmit={createFolderSubmit}>
                <Stack gap={16}>
                    <Text size="sm" c="dimmed">
                        Routinely directs any uploaded file in this folder through a predefined
                        approval workflow
                    </Text>
                    <Radio.Group name="status" defaultValue="active">
                        <Group mt="xs">
                            <Radio value="active" label="Active" />
                            <Radio value="inactive" label="Inactive" />
                        </Group>
                    </Radio.Group>

                    <Textarea
                        label="Resolution"
                        placeholder="Your resolution for this approval"
                        autosize
                        minRows={2}
                        maxRows={4}
                    />

                    <Switch label="Move after successful workflow" />
                </Stack>

                <Flex align="center" justify="end" mt={16}>
                    <Button variant="outline" onClick={close}>
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

const FilterButton = () => {
    const [createApprovalOpened, { open: openCreateApproval, close: closeCreateApproval }] =
        useDisclosure(false);

    return (
        <>
            <Button
                variant="subtle"
                color="dark.3"
                leftSection={<IconFilter size={18} />}
                onClick={openCreateApproval}
            >
                Filter
            </Button>

            <ApprovalForm isOpened={createApprovalOpened} close={closeCreateApproval} />
        </>
    );
};

export default FilterButton;
